function selector(element, ul){
  focusin=false;
  element.addEventListener("click", function (e) {
    focusin=true;
      console.log('click on selector');
        ul.setAttribute("style", "display: block;");
  });


  function closeAll(elmnt){
    var ul = document.getElementsByClassName("selector-disabled");
    for (var i = 0; i < ul.length; i++) {
        if (elmnt != ul[i]) {
            ul.setAttribute("style", "display: none;");
        }
    }
  }


  document.addEventListener("click", function (e) {
      if (!focusin) {
          console.log('removed');
          closeAll(e.target);
      }
  });

}
