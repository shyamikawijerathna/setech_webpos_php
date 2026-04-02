
$(document).on('click', '.increment', function () {
    // Your increment code here
    console.log("Increment clicked"); // Test if this shows in console
});

$(document).on('click', '.decrement', function () {
    // Your decrement code here
    console.log("Decrement clicked"); // Test if this shows in console
});








$(document).ready(function () {

    // --- INCREMENT ---
    $(document).on('click', '.increment', function () {
        var $qtyInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prod_id').val();
        var currentValue = parseInt($qtyInput.val());

        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            QuantityIncDec(productId, qtyVal);
        }
    });

    // --- DECREMENT ---
    $(document).on('click', '.decrement', function () {
        var $qtyInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prod_id').val();
        var currentValue = parseInt($qtyInput.val());

        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            QuantityIncDec(productId, qtyVal);
        }
    });

        function QuantityIncDec(prodId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': prodId,
                'quantity': qty
            },
            success: function (response) {
                try {
                    var res = JSON.parse(response);
                    if (res.status == 200) {
                        window.location.reload();
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                }
            }
        });
    }


    // --- PROCEED TO PLACE ORDER ---
    $(document).on('click', '.proceedToPlace', function (e) {
        e.preventDefault(); 

        var cphone = $('#cphone').val();
        var payment_mode = $('#payment_mode').val();

        // --- NEW: Grab financial values from the UI ---
        // Use .text() if they are in <span>/<td>, use .val() if they are in <input>
        var sub_total = $('#sub_total').text(); 
        var discount = $('#input_discount').val();
        var total_amount = $('#display_final_total').text(); // Matches your PHP $_POST['total_amount']
        var cash_received = $('#input_cash').val();
        var balance = $('#display_balance').text();

        // Validation
        if (payment_mode == null || payment_mode == '') {
            Swal.fire({
                title: "Select Payment Mode",
                text: "Please select your payment mode",
                icon: "warning"
            });
            return false;
        }
        
        if (cphone == '' || !$.isNumeric(cphone)) {
            Swal.fire({
                title: "Enter Phone Number",
                text: "Please enter a valid phone number",
                icon: "warning"
            });
            return false;
        }

       // Convert both to numbers to ensure accurate math comparison
        

                // 1. Check if empty or not a number
                if (cash_received == '' || !$.isNumeric(cash_received)) {
                    Swal.fire({
                        title: "Enter Cash Received",
                        text: "Please enter a valid cash received amount",
                        icon: "warning"
                    });
                    return false;
                }

                // 2. Check if cash is less than the total amount
                if (parseFloat(cash_received) < parseFloat(total_amount)) {
                    Swal.fire({
                        title: "Insufficient Cash",
                        text: "Cash received must be greater than or equal to the total (" + parseFloat(total_amount).toLocaleString() + ")",
                        icon: "error"
                    });
                    return false;
                }

// If both checks pass, the code continues to process the payment...
        // --- UPDATED: Data object now includes financials ---
        var data = {
            'proceedToPlace': true,
            'cphone': cphone,
            'payment_mode': payment_mode,
            'sub_total': sub_total,
            'discount': discount,
            'total_amount': total_amount,
            'cash_received': cash_received,
            'balance': balance
        };

        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function(response) {
                try {
                    var res = JSON.parse(response);

                    if (res.status == 200) {
                        window.location.href = "order-summery.php";
                    } else if (res.status == 404) {
                        Swal.fire({
                            title: res.message,
                            text: "Customer not found in our records",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonText: 'Add Customer',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addCustomerModal').modal('show');
                            }
                        });
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                } catch (e) {
                    console.error("Full Server Response:", response);
                    Swal.fire("Server Error", "The server returned an invalid response. Check the browser console.", "error");
                }
            }
        });
    });

    // save order
$(document).ready(function () {
    $(document).on('click', '#saveOrder', function () {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save this order?",
            icon: "warning",
            showCancelButton: true, // Correct syntax for SweetAlert2
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, save it!"
        }).then((result) => {
            // SweetAlert2 uses result.isConfirmed
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: {
                        'saveOrder': true
                    },
                    success: function (response) {
                        try {
                            var res = JSON.parse(response);
                            if(res.status == 200){
                                // 1. Update the modal text
                                $('#orderPlaceSuccessMessage').text(res.message);
                                
                                // 2. Show the Bootstrap Modal
                                $('#orderSuccessModal').modal('show');

                                // NOTE: Removed the immediate window.location.href 
                                // so the user can actually see the modal.
                                
                            } else {
                                Swal.fire("Error", res.message, "error");
                            }
                        } catch (e) {
                            console.error("JSON Parsing error:", e);
                            Swal.fire("Error", "Invalid response from server", "error");
                        }
                    }
                });
            }
        });
    });
});

   

});



function printMyBillingArea() {
    var cartContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open('', '', 'height=800, width=1000');
   
    a.document.write('<html><head><title>POS Receipt</title><style>');
    a.document.write(`
        @page { 
            size: 80mm auto; 
            margin: 0; 
        }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 72mm; /* Increased slightly to fill the 80mm roll better */
            margin: 0; 
            padding: 2mm 0mm 2mm 2mm; /* Set right padding to 0 to pull text left */
            font-size: 13px;
            color: #000;
            overflow-x: hidden; /* Prevents horizontal scroll/cutoff */
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: auto; /* Changed from fixed to let it breathe */
        }
        /* Specifically push the total column away from the very edge */
        .text-right { 
            text-align: right; 
            padding-right: 5px; /* Adds a tiny internal buffer for digits */
        }
        .text-center { text-align: center; }
        .dashed-border { border-bottom: 1px dashed #000; }
        .solid-border { border-bottom: 1px solid #000; }
        
        /* HIDDEN ELEMENTS: This removes buttons if they are inside the div */
        button, .no-print, .btn, .footer-section { 
            display: none !important; 
        }

        td, th { word-wrap: break-word; }
    `);
    a.document.write('</style></head><body>');
    a.document.write(cartContents); 
    a.document.write('</body></html>');
    a.document.close();

    a.focus();
    setTimeout(function(){ 
        a.print(); 
        a.close();
    }, 500);
}

 window.jsPDF = window.jspdf.jsPDF;
 var docPDF =new jsPDF;

function downloadPDF(invoiceNo){

        var elementHTML =document.querySelector("#myBillingArea");
        docPDF.html(elementHTML,{
            callback: function() {
                docPDF.save(invoiceNo+'.pdf');

            },
            x: 15,
            y: 15,
            width : 170,
            windowWidth: 650

        });


}

function printMyBillingArea1() {
    var cartContents = document.getElementById("myBillingArea1").innerHTML;
    var printWindow = window.open('', '', 'height=800, width=400'); // Narrower window

    printWindow.document.write('<html><head><title>POS Receipt</title>');
    printWindow.document.write('<style>');
    // Crucial CSS for 80mm Thermal Printers
    printWindow.document.write(`
        @page { size: auto; margin: 0mm; }
        body { 
            width: 80mm; 
            margin: 0; 
            padding: 5px; 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 12px;
        }
        img { max-width: 100%; height: auto; }
        table { width: 100%; border-collapse: collapse; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        hr { border-top: 1px dashed #000; }
    `);
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(cartContents); 
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();

    // Small delay to ensure styles/images are loaded before printing
    setTimeout(function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }, 250);
}


    //for alert - Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                // Use Bootstrap's built-in 'close' method
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 4000); // 4000ms = 4 seconds
        }
    });

