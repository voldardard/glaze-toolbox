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
          closeAll();
          focusin=false;
      }
  });
};
function closeAll(){
  console.log('closeAll triggered');
  var uls = document.getElementsByClassName("selector-disabled");
  console.log('got element');
  for (var i = 0; i < uls.length; i++) {
      console.log("close"+i);
      //if (elmnt != uls[i]) {
          uls[i].setAttribute("style", "display: none;");
      //}
  }
};
