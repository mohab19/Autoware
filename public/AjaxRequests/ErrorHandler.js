/**
 * function to get errors and handle them.
 * array of selectors
 * @param error
 * @param selectors
 * @param fields
 */

function error_handler(error,selectors,fields) {
    var error_text = "";
    for (var i = 0; i < fields.length;i++)
    {
        error_text = error[fields[i]];
        if(error.hasOwnProperty(fields[i]))
        {
            $(selectors[i]).html(error_text);
            $(selectors[i]).addClass("alert alert-danger");
            $(selectors[i]).fadeIn(50);
        }
        else {
            $(selectors[i]).html("");
            $(selectors[i]).removeClass("alert alert-danger");
            $(selectors[i]).fadeOut(50);
        }
    }
}

/**
 * function to empty out the error labels
 * @param selectors
 */
// function hide_empty_labels(FormID) {
//     if($("#"+FormID+" label.alert-danger").html()==0)
//     {
//         alert(1);
//     }
// }
function empty_errors(selectors) {
    for(var i = 0; i < selectors.length ; i++)
    {
        $(selectors[i]).html('');
    }
}

/**
 * function to take selector and print out the text on it
 * @param selector
 * @param text
 * @param type
 */
function PrintOnSelector(selector,text,type) {
    $(selector).html(text);
}
var text ;
function button_waiting(selector)
{
    text = selector.text();
    selector.html("جاري التنفيذ <i class='fa fa-gear'></i>");
    selector.css({
        background:"#dd4c44",
        opacity:.5
    });
    selector.prop('disabled', true)
}
function button_done(selector)
{
    selector.html(text);
    selector.css({
        background:"#e7534b",
        opacity:1
    });
    selector.prop('disabled', false)
}
