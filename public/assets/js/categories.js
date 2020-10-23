function open_selector(id){
  element = document.getElementById('selector-list-'+id);
  element.setAttribute("style", "display: block;")

  element.addEventListener("focusout", function (e) {
      console.log('focus out of selector');
  });

}
