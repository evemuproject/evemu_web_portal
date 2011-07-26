        function Help(section) {
      q=window.open('index.php?mod=help&section='+section, 'Help', 'scrollbars=1,resizable=1,width=450,height=400');
        }

        function ShowOrHide(d1, d2) {
          if (d1 != '') DoDiv(d1);
          if (d2 != '') DoDiv(d2);
        }
        function DoDiv(id) {
          var item = null;
          if (document.getElementById) {
                item = document.getElementById(id);
          } else if (document.all){
                item = document.all[id];
          } else if (document.layers){
                item = document.layers[id];
          }
          if (!item) {
          }
          else if (item.style) {
                if (item.style.display == "none"){ item.style.display = ""; }
                else {item.style.display = "none"; }
          }else{ item.visibility = "show"; }
         }