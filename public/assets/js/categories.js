function selector(id){
  element = document.getElementById('selector-list-'+id);
  console.log('Enter in');


  element.addEventListener("mouseover", function (e) {
      console.log('focus hover of selector');
  });
  element.addEventListener("click", function (e) {
      console.log('focus click of selector');
        element.setAttribute("style", "display: block;")
  });

  element.addEventListener("mouseout", function (e) {
      console.log('focus out of selector');
      element.setAttribute("style", "display: none;")
  });

}
