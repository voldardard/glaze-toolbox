function selector(element, ul){
  console.log('activate in');

  element.addEventListener("mouseover", function (e) {
      console.log('mouse hover of selector');
  });
  element.addEventListener("click", function (e) {
      console.log('click on selector');
        ul.setAttribute("style", "display: block;")
  });

  element.addEventListener("mouseout", function (e) {
      console.log('mouse out of selector');
      ul.setAttribute("style", "display: none;")
  });

}
