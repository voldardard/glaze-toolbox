function open_selector(id){
  element = document.getElementById('selector-list-'+id);


  element.addEventListener("mouseover", function (e) {
      console.log('focus in of selector');
        element.setAttribute("style", "display: block;")
  });

  element.addEventListener("mouseout", function (e) {
      console.log('focus out of selector');
      element.setAttribute("style", "display: none;")
  });

}
