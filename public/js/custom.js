function copyToClipboard(){
    console.log(this);
}
  
function logout() {
    var x = document.getElementById("logoutform");
    x.submit();
}
  
  
function templateInput(text_label = '', value_label = '', name_label = '', type = 'text', readonly = true){
    if(type == 'hidden'){
        return '<input type="hidden" name="' + name_label + '" value="' + value_label + '">';
    }else if(type == 'textarea'){
        return '<div class="form-group col-md-12">' + 
            '<label class="required">' + text_label + '</label>' +
            '<textarea class="form-control" name="' + name_label + '" ' + (readonly ? 'readonly' : '') + '>' + value_label + '</textarea>' +
        '</div>';
    }
    return '<div class="form-group col-md-12">' + 
        '<label class="required">' + text_label + '</label>' +
        '<input type="' + type + '" class="form-control" name="' + name_label + '" value="' + value_label + '" ' + (readonly ? 'readonly' : '') + '/>' +
    '</div>';
}
  
function scrollOnTopElement(el){
    let el_width = $(el).width()
    let wrap = $('<div class="scrollable-top"></div>')
                  .css('width', '100%')
                  .css('overflow-x', 'auto')
                  .on( "scroll", function(){
                    $(".scrollable-top").not(this).scrollLeft($(this).scrollLeft());
                  })
                  // .attr('-webkit-overflow-scrolling','touch');
    let top_el = $('<div>&nbsp;</div>').width(el_width)
    $(el).wrap(wrap)
    $(el).parent().before(top_el);
    top_el.wrap(wrap)
    .css('height','1px');
}
  
function setCookie(cname, cvalue, exdays = 7)
{
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";SameSite=Strict;path=/";
}
function deleteCookie(cname)
{
      document.cookie = cname + "=;expires=Thu; 01 Jan 1970;SameSite=Strict;path=/";
}
function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++)
    {
        var c = ca[i];
        while (c.charAt(0) == ' ')
        {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0)
        {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
  
function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}
  
function formatCurrency(input, is_input=true, blur, prepend_symbol = '') {
    // appends $ to value, validates decimal side
    // prepend_symbol = "$"
    // and puts cursor back in right position.
    
    // get input value
    var input_val = is_input ? input.val() : input.text();
  
    // don't validate empty input
    if (input_val === "") { return; }
    
    // original length
    var original_len = input_val.length;
  
    if(is_input){
        // initial caret position 
        var caret_pos = input.prop("selectionStart");
    }
      
    // check for decimal
    if (input_val.indexOf(".") >= 0) {
  
      // get position of first decimal
      // this prevents multiple decimals from
      // being entered
      var decimal_pos = input_val.indexOf(".");
  
      // split number by decimal point
      var left_side = input_val.substring(0, decimal_pos);
      var right_side = input_val.substring(decimal_pos);
  
      // add commas to left side of number
      left_side = formatNumber(left_side);
  
      // validate right side
      right_side = formatNumber(right_side);
      
      // On blur make sure 2 numbers after decimal
      if (blur === "blur") {
        right_side += "00";
      }
      
      // Limit decimal to only 2 digits
      right_side = right_side.substring(0, 2);
  
      // join number by .
      input_val = prepend_symbol + left_side + "." + right_side;
  
    } else {
      // no decimal entered
      // add commas to number
      // remove all non-digits
      input_val = formatNumber(input_val);
      input_val = prepend_symbol + input_val;
      
      // final formatting
      if (blur === "blur") {
        input_val += ".00";
      }
    }
    
    if(is_input){
      // send updated string to input
      input.val(input_val);
  
      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }else{
      // send updated string to input
      input.text(input_val);  
    }
}