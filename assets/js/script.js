let maxLength = ( cct_object.data.max_character ? cct_object.data.max_character : 100 );
let totalChars = 0;

counter = function() {    
    var value = jQuery(this).val();


    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;

    // jQuery('#wordCount').html(wordCount);
    // jQuery('#totalChars').html(totalChars);
    // jQuery('#charCount').html(charCount);
    // jQuery('#charCountNoSpace').html(charCountNoSpace);

    var counter_text = ( cct_object.data.counter_text ? cct_object.data.counter_text : '%characters_count% / %max_count%' );
    counter_text = counter_text.replaceAll('%characters_count%',totalChars);
    counter_text = counter_text.replaceAll('%max_count%',maxLength);

    jQuery(this).next('.cct-count-wrapper').find('.count-details').html(counter_text);

    if( cct_object.data.display_progress == 1 ) {
        percentage( jQuery(this) );
    }
};

function percentage( ele ) {

    let percentage = ( totalChars / maxLength ) * 100;    
    
    ele.next('.cct-count-wrapper').find('.perc-am-fd').css('width',percentage+'%');
    if( percentage > 60 && percentage < 80 ) {
        ele.next('.cct-count-wrapper').find('.perc-am-fd').css('background-color','#ffdf80');
    } else if ( percentage >= 80 ) {
        ele.next('.cct-count-wrapper').find('.perc-am-fd').css('background-color','#f06292');
    } else {
        ele.next('.cct-count-wrapper').find('.perc-am-fd').css('background-color','#11a683');
    }
}

jQuery(document).ready(function() {

    if( cct_object.data.enable != 1 ) {
        return;
    }

    var counter_text = ( cct_object.data.counter_text ? cct_object.data.counter_text : '%characters_count% / %max_count%' );
    counter_text = counter_text.replaceAll('%characters_count%',totalChars);
    counter_text = counter_text.replaceAll('%max_count%',maxLength);
    
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).after('<div class="cct-count-wrapper"><div class="count-details">'+counter_text+'</div><div class="percentage-fd"><div class="perc-am-fd"></div></div></div>');
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).attr('maxlength',maxLength);

    jQuery( '.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' ) ).each(function() {
        let textareaWidth = jQuery(this).width();
        jQuery(this).next('.cct-count-wrapper').css('margin-left',( textareaWidth - 40 )+'px');
    });
    
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).change(counter);
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).keydown(counter);
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).keypress(counter);
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).keyup(counter);
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).blur(counter);
    jQuery('.cct-count'+ ( cct_object.data.classes_to_apply != '' ? ', ' + cct_object.data.classes_to_apply : '' )).focus(counter);
});