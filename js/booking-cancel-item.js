/**
 * Booking Item Cancellation Module
 * Handles item selection and cancellation with charges
 */

(function($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function() {
        initializeCancelCheckboxes();
    });

    /**
     * Initialize iCheck for cancel item checkboxes
     */
    function initializeCancelCheckboxes() {
        $('.cancel-item-checkbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });

        // Handle iCheck events for toggle button
        $('.cancel-item-checkbox').on('ifChecked ifUnchecked', function(event) {
            toggleCancelButton();
        });
    }

    /**
     * Toggle Cancel Item button visibility based on checkbox selection
     */
    window.toggleCancelButton = function() {
        var checkedCount = 0;
        $('.cancel-item-checkbox').each(function() {
            if ($(this).prop('checked')) {
                checkedCount++;
            }
        });
        
        var $cancelBtnContainer = $('#cancel-item-btn-container');
        if (checkedCount > 0) {
            $cancelBtnContainer.fadeIn();
        } else {
            $cancelBtnContainer.fadeOut();
        }
    };

    /**
     * Cancel selected items with charges popup
     */
    window.cancelSelectedItems = function() {
        var selectedItems = [];
        
        // Collect selected items with their details
        $('.cancel-item-checkbox').each(function() {
            if ($(this).prop('checked')) {
                var itemIndex = $(this).attr('data-item-index');
                var itemDesc = $('#bookingitem-' + itemIndex + '-description').val();
                var itemAmount = $('#bookingitem-' + itemIndex + '-amount').val();
                
                selectedItems.push({
                    index: itemIndex,
                    description: itemDesc || 'Item ' + itemIndex,
                    amount: itemAmount || '0.00'
                });
            }
        });
        
        if (selectedItems.length === 0) {
            swal({
                title: "No Items Selected",
                text: "Please select at least one item to cancel.",
                icon: "warning",
                button: "OK",
            });
            return;
        }

        // Calculate total amount of selected items
        var totalAmount = selectedItems.reduce(function(sum, item) {
            return sum + parseFloat(item.amount || 0);
        }, 0);

        // Build items list for display
        var itemsList = selectedItems.map(function(item, idx) {
            return (idx + 1) + '. ' + item.description + ' - ₹' + parseFloat(item.amount).toFixed(2);
        }).join('<br>');

        // Show popup with cancellation charges input
        swal({
            title: "Cancel Items",
            content: {
                element: "div",
                attributes: {
                    innerHTML: '<div style="text-align: left; margin-bottom: 15px;">' +
                        '<p><strong>Selected Items:</strong></p>' +
                        '<div style="margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 4px; max-height: 150px; overflow-y: auto;">' +
                        itemsList +
                        '</div>' +
                        '<p style="margin-top: 10px;"><strong>Total Amount: ₹' + totalAmount.toFixed(2) + '</strong></p>' +
                        '<hr style="margin: 15px 0;">' +
                        '<label for="cancellation-charges" style="display: block; margin-bottom: 8px; font-weight: 600;">' +
                        'Cancellation Charges:' +
                        '</label>' +
                        '<div style="display: flex; gap: 10px; align-items: center;">' +
                        '<div style="flex: 1; position: relative;">' +
                        '<input type="number" id="cancellation-charges" class="swal-content__input" ' +
                        'placeholder="Enter amount" min="0" step="0.01" value="0" ' +
                        'style="width: 100%; padding: 10px 45px 10px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">' +
                        '<span id="charge-unit" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); ' +
                        'font-weight: 600; color: #333; pointer-events: none;">₹</span>' +
                        '</div>' +
                        '<div class="btn-group" role="group" style="flex-shrink: 0;">' +
                        '<button type="button" id="charge-type-fixed" class="btn btn-sm btn-primary" ' +
                        'style="padding: 10px 18px; border-radius: 4px 0 0 4px; font-size: 18px; font-weight: 600;" title="Fixed Amount">' +
                        '₹' +
                        '</button>' +
                        '<button type="button" id="charge-type-percent" class="btn btn-sm btn-outline-primary" ' +
                        'style="padding: 10px 18px; border-radius: 0 4px 4px 0; font-size: 18px; font-weight: 600;" title="Percentage">' +
                        '%' +
                        '</button>' +
                        '</div>' +
                        '</div>' +
                        '<small id="charge-helper" style="color: #666; display: block; margin-top: 5px;">Enter fixed amount in rupees</small>' +
                        '<div id="calculated-amount" style="margin-top: 10px; padding: 8px; background: #fff3cd; border-left: 3px solid #ffc107; display: none;">' +
                        '<strong>Calculated Charges: ₹<span id="calc-value">0.00</span></strong>' +
                        '</div>' +
                        '</div>'
                }
            },
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "Confirm Cancellation",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: false
                }
            },
            dangerMode: true,
        }).then((willCancel) => {
            if (willCancel) {
                var chargeValue = parseFloat($('#cancellation-charges').val()) || 0;
                var isPercentage = $('#charge-type-percent').hasClass('btn-primary');
                var actualCharges = chargeValue;
                
                if (isPercentage) {
                    // Calculate percentage of total amount
                    actualCharges = (totalAmount * chargeValue) / 100;
                }
                
                processCancellation(selectedItems, actualCharges, totalAmount, chargeValue, isPercentage);
            }
        });

        // Add event handlers for the toggle buttons after swal renders
        setTimeout(function() {
            setupChargeTypeToggle(totalAmount);
        }, 100);
    };

    /**
     * Setup toggle between Fixed Amount and Percentage
     */
    function setupChargeTypeToggle(totalAmount) {
        var $fixedBtn = $('#charge-type-fixed');
        var $percentBtn = $('#charge-type-percent');
        var $input = $('#cancellation-charges');
        var $unit = $('#charge-unit');
        var $helper = $('#charge-helper');
        var $calculatedDiv = $('#calculated-amount');
        var $calcValue = $('#calc-value');

        // Toggle to Fixed Amount
        $fixedBtn.on('click', function() {
            if (!$(this).hasClass('btn-primary')) {
                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                $percentBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                
                $unit.text('₹');
                $input.attr('placeholder', 'Enter fixed amount');
                $input.attr('max', '');
                $helper.text('Enter fixed amount in rupees');
                $calculatedDiv.hide();
                
                // Reset value
                $input.val('0');
            }
        });

        // Toggle to Percentage
        $percentBtn.on('click', function() {
            if (!$(this).hasClass('btn-primary')) {
                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                $fixedBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                
                $unit.text('%');
                $input.attr('placeholder', 'Enter percentage');
                $input.attr('max', '100');
                $helper.text('Enter percentage of total amount (0-100%)');
                $calculatedDiv.show();
                
                // Reset value
                $input.val('0');
                $calcValue.text('0.00');
            }
        });

        // Calculate on input change when percentage mode
        $input.on('input', function() {
            if ($percentBtn.hasClass('btn-primary')) {
                var percentage = parseFloat($(this).val()) || 0;
                
                // Validate percentage
                if (percentage > 100) {
                    $(this).val(100);
                    percentage = 100;
                }
                
                var calculated = (totalAmount * percentage) / 100;
                $calcValue.text(calculated.toFixed(2));
            }
        });
    }

    /**
     * Process the cancellation of items
     */
    function processCancellation(items, charges, totalAmount, inputValue, isPercentage) {
        // Show loading
        swal({
            title: "Processing...",
            text: "Cancelling selected items",
            icon: "info",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
        });

        // Get booking ID
        var bookingId = $('input[name="BookingHeader[booking_id]"]').val() || 
                        $('#bookingheader-booking_id').val() || 
                        $('input[id*="booking_id"]').first().val();

        // Prepare data for each item
        var itemsData = items.map(function(item, idx) {
            var itemId = $('#bookingitem-' + item.index + '-item_id').val();
            var productId = $('#bookingitem-' + item.index + '-product_id').val();
            var rentAmount = parseFloat($('#bookingitem-' + item.index + '-amount').val()) || 0;
            var description = $('#bookingitem-' + item.index + '-description').val() || item.description;
            
            // Calculate earning amount per item
            var earningAmount = 0;
            if (isPercentage) {
                // Calculate percentage of rent amount for each item
                earningAmount = (rentAmount * inputValue) / 100;
            } else if (idx === 0) {
                // Put fixed amount to first item only
                earningAmount = charges;
            }

            return {
                item_id: itemId,
                product_id: productId,
                booking_id: bookingId,
                charges_amount: earningAmount,
                rent_amount: rentAmount,
                original_description: description,
                item_index: item.index
            };
        });

        // Send AJAX request to cancel items
        $.ajax({
            url: 'index.php?r=booking/cancel-items', // Update with your actual endpoint
            type: 'POST',
            data: {
                booking_id: bookingId,
                items: itemsData,
                charge_type: isPercentage ? 'percentage' : 'fixed',
                charge_value: inputValue,
                total_charges: charges,
                _csrf: $('meta[name="csrf-token"]').attr('content') || yii.getCsrfToken()
            },
            success: function(response) {
                console.log('Server response:', response);
                
                // Update UI for each cancelled item
                itemsData.forEach(function(itemData) {
                    var index = itemData.item_index;
                    
                    // Update item status to Cancelled
                    $('#bookingitem-' + index + '-item_status').val('Cancelled');
                    
                    // Update deposit amount to 0
                    $('#bookingitem-' + index + '-deposit_amount').val('0');
                    
                    // Update description
                    var newDesc = 'Cancel ' + itemData.original_description;
                    $('#bookingitem-' + index + '-description').val(newDesc);
                    
                    // Visually mark the row as cancelled
                    var $row = $('#bookingitem-' + index + '-test');
                    $row.css({
                        'background-color': '#ffebee',
                        'opacity': '0.8'
                    });
                    
                    // Add cancelled badge
                    var $descCell = $row.find('.item_details_lable');
                    if ($descCell.find('.cancelled-badge').length === 0) {
                        $descCell.prepend(
                            '<span class="cancelled-badge" style="display: inline-block; background: #f44336; color: white; ' +
                            'padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-right: 5px; font-weight: bold;">' +
                            'CANCELLED</span>'
                        );
                    }
                    
                    // Disable and uncheck the checkbox
                    $('#bookingitem-' + index  +'-cancel_checkbox').iCheck('uncheck');
                    $('#bookingitem-' + index + "-cancel_checkbox").iCheck('disable');
                });

                // Hide the cancel button
                toggleCancelButton();

                // Recalculate totals if needed
                if (typeof add === 'function') {
                    add();
                }

                // Show success message
                var chargeText = isPercentage 
                    ? inputValue + "% (₹" + charges.toFixed(2) + ")" 
                    : "₹" + charges.toFixed(2);
                    
                swal({
                    title: "Items Cancelled!",
                    text: items.length + " item(s) cancelled successfully.\n" +
                          "Cancellation Charges: " + chargeText,
                    icon: "success",
                    button: "OK",
                });
            },
            error: function(xhr, status, error) {
                console.error('Error saving cancellation:', error);
                console.error('Response:', xhr.responseText);
                
                swal({
                    title: "Error!",
                    text: "Failed to cancel items. Please try again.\n" + 
                          (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error),
                    icon: "error",
                    button: "OK",
                });
            }
        });
    }

})(jQuery);

