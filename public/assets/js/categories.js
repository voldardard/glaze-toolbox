function selector(element, ul){

  element.addEventListener("click", function (e) {
      console.log('click on selector');
        ul.setAttribute("style", "display: block;")
        ul.addEventListener("mouseover", function (e) {
            console.log('mouse hover of selector-items');
        });
        ul.addEventListener("mouseout", function (e) {
            console.log('mouse out of selector-item');
            ul.setAttribute("style", "display: none;")
        });
  });


  element.addEventListener("focusout", function (e) {
      console.log('focus out of selector');

      ul.setAttribute("style", "display: none;")
  });

}
