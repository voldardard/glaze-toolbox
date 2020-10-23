focusin=false;
function selector(element, ul){
  element.addEventListener("click", function (e) {
      console.log('click on selector');
      focusin=true;

      closeAll();
      console.log('Close All before open one');

      ul.setAttribute("style", "display: block;");
      console.log('set attribute block');
  });
  element.addEventListener("mouseout", function (e) {
      console.log('mouseout of div');
      focusin=false;
  });
  element.addEventListener("mouseover", function (e) {
      console.log('mouseover of div');
      focusin=true;
  });

};
function closeSelectorEvent(){
  console.log('Close Selector triggered');
  //closeSelectorEvent()=function(){};
  document.addEventListener("click", function (e) {
    console.log('click outside');
    if (!focusin){
        closeAll();
        console.log('closeAll')
    }

  });
};
function closeAll(){
  console.log('closeAll triggered');
  var uls = document.getElementsByClassName("selector_disabled");
  console.log('got element'+uls.length);
  for (var i = 0; i < uls.length; i++) {
      //console.log("close"+i);
      //if (elmnt != uls[i]) {
          uls[i].setAttribute("style", "display: none;");
      //}
  }
};
