// print function


function Popup(data) {
    var mywindow = window.open('', 'amount_image', 'height=1000,width=1000');
    //mywindow.document.write('<html><head><title>QR Code Image</title>');
    //mywindow.document.write('</head><body>');
    mywindow.document.write('<img  src="' + data + '" width="400px" height="400px"">');
    //mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10
    mywindow.print();
    return true;
}

function HideElement(selector) {
    $(selector).hide();
}

function ShowElement(selector) {
    $(selector).show();
}

