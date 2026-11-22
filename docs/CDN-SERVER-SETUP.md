# Image CDN (Cloudflare) and thumbnails: server setup

Item images stay on GoDaddy hosting (`public_html/app/uploads/`) and are served through Cloudflare at
`https://cdn.thesoyara.com/app/uploads/...`. Only the `cdn` subdomain goes through Cloudflare's proxy;
`thesoyara.com`, `www` and email keep working exactly as before.

Thumbnails (400px wide JPEG) are written to `uploads/thumbs/<same path>.jpg` on every upload by
`common\components\ImageHelper`. Grids and lists use thumbnails; previews, popups and invoices use the full image.
All image URLs come from `Yii::$app->params['imageCdnBase']`. When it's empty, the app serves images from its own URL.

Follow the steps in order.

---

## Step A: GoDaddy hosting (cPanel), before any DNS change

1. In GoDaddy, go to **My Products**, then **Web Hosting**, then **cPanel Admin**.
2. **Enable GD and EXIF:** in cPanel, open **Select PHP Version**, then **Extensions**, tick `gd` and `exif`, and save.
   (Without GD, uploads still work but no thumbnails are created, and the app shows full images.)
3. **Create the subdomain:** go to **Domains**, then **Create A New Domain**, and enter `cdn.thesoyara.com`.
   - Tick **Share document root (public_html) with thesoyara.com**, so that
     `https://cdn.thesoyara.com/app/uploads/...` serves the same files as `https://thesoyara.com/app/uploads/...`.
   - If the old cPanel UI shows "Subdomains" instead, set the document root to `public_html`.
4. **Back up DNS:** go to GoDaddy, then **Domain Portfolio**, then **thesoyara.com**, then **DNS**, and take screenshots or an export of
   every record (A, CNAME, MX, TXT/SPF/DKIM/DMARC, SRV). You will compare against this in Step B.
5. Add a temporary record in GoDaddy DNS: **A** record, name `cdn`, value = the same IP as the `@` record.
6. In cPanel, go to **SSL/TLS Status**, select `cdn.thesoyara.com`, and click **Run AutoSSL**. Wait until it shows a valid certificate.
7. Check that `https://cdn.thesoyara.com/app/img/no-image.jpg` opens in a browser.

## Step B: Add the domain to Cloudflare

1. Sign up at <https://dash.cloudflare.com>, click **Add a domain**, enter `thesoyara.com`, and choose the **Free** plan.
2. Cloudflare imports the DNS records. **Compare them with the Step A.4 backup** and add anything missing,
   especially MX, SPF (`v=spf1 ...`), DKIM, DMARC, and any verification TXT records.
3. Set **Proxy status** for each record:

   | Record | Proxy |
   |---|---|
   | `@` (A) | DNS only (grey) |
   | `www` | DNS only (grey) |
   | `cdn` (A, same IP as `@`) | **Proxied (orange)** |
   | `mail`, `ftp`, `cpanel`, `webmail`, MX, TXT | DNS only (grey) |

4. Write down the two Cloudflare nameservers shown (for example `anna.ns.cloudflare.com`, `bob.ns.cloudflare.com`).

## Step C: Point GoDaddy at Cloudflare

1. In GoDaddy, go to **Domain Portfolio**, then **thesoyara.com**, then **DNS**.
2. If **DNSSEC** is on, turn it off first. Leaving it on breaks the domain after the switch.
3. Open the **Nameservers** tab, click **Change Nameservers**, choose **I'll use my own nameservers**, enter both Cloudflare nameservers, and save.
4. Wait for Cloudflare's email "thesoyara.com is now active". This usually takes 15 minutes to a few hours, and up to 24 hours.
5. Check right away:
   - `https://thesoyara.com/app` loads and you can log in.
   - Send and receive one test email.

## Step D: Cloudflare settings

1. In **SSL/TLS**, then **Overview**, set the mode to **Full (strict)**. If `cdn.` shows error 526, use **Full**.
2. In **SSL/TLS**, then **Edge Certificates**, turn on **Always Use HTTPS**.
3. Go to **Caching**, then **Cache Rules**, and click **Create rule**:
   - Name: `CDN images`
   - Custom filter expression:
     `(http.host eq "cdn.thesoyara.com" and (starts_with(http.request.uri.path, "/app/uploads/") or starts_with(http.request.uri.path, "/app/img/")))`
   - Cache eligibility: **Eligible for cache**
   - Edge TTL: **Ignore cache-control header and use this TTL**, set to **1 month**
   - Browser TTL: **Override origin and use this TTL**, set to **7 days**
   - Deploy.
4. In **Caching**, then **Configuration**, leave Browser Cache TTL at **Respect existing headers**.
5. Optional: turn on **Scrape Shield** and then **Hotlink Protection**, so other sites can't embed your images.

## Step E: Deploy the Yii app (`app_soyara`, branch `feature/cdn-thumbnails`)

1. Deploy the branch using your usual method (git pull, cPanel **Git Version Control**, or FTP of the changed files):
   - `common/components/ImageHelper.php` (new)
   - `common/config/params.php`
   - `uploads/.htaccess` (new; File Manager hides dotfiles, so turn on **Settings** and then **Show Hidden Files**)
   - `backend/controllers/ItemController.php`, `backend/controllers/ApiController.php`
   - `backend/components/HelperComponent.php`, `backend/models/ItemMaster.php`
   - changed views under `backend/views/`
2. On the **server only**, edit `common/config/params-local.php`:
   ```php
   <?php
   return [
       'imageCdnBase' => 'https://cdn.thesoyara.com/app',
   ];
   ```
   If the server deploys with `git pull`, stop git overwriting this file:
   `git update-index --skip-worktree common/config/params-local.php`
3. Make sure `public_html/app/uploads/` is writable by PHP (`755`, owned by the cPanel user). The app creates
   `uploads/thumbs/` automatically.
4. **Backfill thumbnails for existing images:** log in to the admin as a user with `manage_item_master`, then open
   `https://thesoyara.com/app/index.php?r=item/generate-thumbs&offset=0&limit=100`.
   The JSON response shows `next_offset` and `done`. Open the URL again with `offset=<next_offset>` until `"done": true`.
   Names listed in `failed` are database rows whose file is missing or not an image. Those items keep showing the full image or the no-image placeholder.

## Step F: Deploy the menu app (`soyara_menu_app`, branch `feature/cdn-thumbnails`)

1. Run `npm run publish:output`. This builds and copies the output to `../client-menu`.
2. Upload the contents of `client-menu/` to `public_html/client-menu/`.
3. No `.env.production` change is needed. Image URLs come from the API.

## Step G: Verify

- `curl -I https://cdn.thesoyara.com/app/uploads/<any-image>`, run twice. The second response should show
  `cf-cache-status: HIT` and a `cache-control: public, max-age=...` header.
- `https://thesoyara.com/client-menu/` in DevTools, then **Network**, then **Img**: grid images come from
  `cdn.thesoyara.com/app/uploads/thumbs/...` (tens of KB each); the full image loads only when a preview opens.
- Admin item list and gallery: thumbnails load. Upload a new image and check that a file appears in `uploads/thumbs/`.

## Rollback

- **Code / URLs:** set `'imageCdnBase' => ''` in the server `params-local.php`. All URLs go back to
  `thesoyara.com/app/uploads/...` immediately.
- **CDN problems:** in Cloudflare DNS, switch `cdn` to **DNS only**.
- **Full DNS rollback (last resort):** in GoDaddy, set Nameservers back to **GoDaddy defaults**. GoDaddy keeps the old records.
- **Stale image after replacing a file:** go to Cloudflare, then **Caching**, then **Configuration**, then **Purge Cache**, then **Custom Purge**, and enter the URL.

## Local development (XAMPP)

- Leave `imageCdnBase` empty. Images are served from `http://localhost/app_soyara/uploads/...`.
- To generate thumbnails locally, enable GD: in `D:\xampp_8_1_25\php\php.ini`, uncomment `extension=gd`, then restart Apache.
