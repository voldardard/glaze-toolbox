focusin=false;

function selector(element, ul){
  element.addEventListener("click", function (e) {
    focusin=true;
      console.log('click on selector');
        ul.setAttribute("style", "display: block;");
  });

};
function closeSelectorEvent(){
  console.log('Close Selector triggered');
  //closeSelectorEvent()=function(){};
  document.addEventListener("click", function (e) {
    console.log('click outside');
      if (!focusin) {
          console.log('removed');
          closeAll(e.target);
          focusin=false;
      }
  });
};
function closeAll(elmnt){
  console.log('closeAll triggered');
  var uls = document.getElementsByClassName("selector-disabled");
  for (var i = 0; i < uls.length; i++) {
      if (elmnt != uls[i]) {
          uls[i].setAttribute("style", "display: none;");
      }
  }
};
