function selector(element, ul){
  element.addEventListener("mouseover", function (e) {
      console.log('mouse hover of selector');
  });
  element.addEventListener("click", function (e) {
      console.log('click on selector');
        ul.setAttribute("style", "display: block;")
  });

/*  element.addEventListener("mouseout", function (e) {
      console.log('mouse out of selector');
      ul.setAttribute("style", "display: none;")
  });*/
  element.addEventListener("focusout", function (e) {
      console.log('focus out of selector');
      ul.setAttribute("style", "display: none;")
  });

}
