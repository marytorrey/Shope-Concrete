function getFieldValue(field)
{
   switch(field.type)
   {
      case "text" :
      case "textarea" :
      case "password" :
      case "hidden" :
         return field.value;

      case "select-one" :
         var i = field.selectedIndex;
         if (i == -1)   return "";
         else   return (field.options[i].value == "") ? field.options[i].text : field.options[i].value;

      case "select-multiple" :
         var allChecked = new Array();
         for(i = 0; i < field.options.length; i++)
            if(field.options[i].selected)
               allChecked[allChecked.length] = (field.options[i].value == "") ? field.options[i].text : field.options[i].value;
         return allChecked;

      case "button" :
      case "reset" :
      case "submit" :
         return "";

      case "radio" :
      case "checkbox" :
         if (field.checked) { return field.value; } else { return ""; }
      default :
         if(field[0].type == "radio")
         {
            for (i = 0; i < field.length; i++)
               if (field[i].checked)
                  return field[i].value;

            return "";
         }
         else if(field[0].type == "checkbox")
         {
            var allChecked = new Array();
            for(i = 0; i < field.length; i++)
               if(field[i].checked)
                  allChecked[allChecked.length] = field[i].value;

            return allChecked;
         }
         else
            var str = "";
            for (x in field) { str += x + "\n"; }
            alert("I couldn't figure out what type this field is...\n\n" + field.name + ": ???\n\n\n" + str + "\n\nlength = " + field.length);
         break;
   }
   
   return "";
}

function formatCurrency(num) {
var isneg;
num = num.toString().replace(/\$|\,/g,'');
if(num < 0) isneg=true;
num = num.toString().replace(/\-/g,'');
if(isNaN(num)) num = "0";
cents = Math.floor((num*100+0.5)%100);
num = Math.floor(num).toString();
if(cents < 10) cents = "0" + cents;
//for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
//num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
if(isneg){
return ( '-' + num + '.' + cents);
}
else{
return ( num + '.' + cents);
}
}