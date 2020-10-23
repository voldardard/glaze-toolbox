function selector(element, ul){
  element.addEventListener("click", function (e) {
    closeAll();
      console.log('click on selector');
        ul.setAttribute("style", "display: block;");
  });

};
function closeSelectorEvent(){
  console.log('Close Selector triggered');
  //closeSelectorEvent()=function(){};
  document.addEventListener("click", function (e) {
    console.log('click outside');
    closeAll();
  });
};
function closeAll(){
  console.log('closeAll triggered');
  var uls = document.getElementsByClassName("selector_disabled");
  console.log('got element'+uls.length);
  for (var i = 0; i < uls.length; i++) {
      console.log("close"+i);
      //if (elmnt != uls[i]) {
          uls[i].setAttribute("style", "display: none;");
      //}
  }
};
