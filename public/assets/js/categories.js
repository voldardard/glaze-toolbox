focusin=false;

function selector(element, ul){
  element.addEventListener("click", function (e) {
      focusin=true;

      closeAll();
      element.classList.add("selector_target");
      ul.setAttribute("style", "display: block;");
  });
  element.addEventListener("mouseout", function (e) {
      focusin=false;
  });
  element.addEventListener("mouseover", function (e) {
      focusin=true;
  });

};
function closeSelectorEvent(){
  console.log('Close Selector enable');
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
          uls[i].parentElement.classList.remove("selector_target");
      //}
  }
};
function update_name(id, value){
  div= document.getElementById('name-'+id);
  while(div.firstChild){
      div.removeChild(div.firstChild);
  }
  var input = document.createElement('input');
  input.setAttribute("required", "required");
  input.setAttribute("type", "text");
  input.setAttribute("placeholder", 'Category name');
  input.setAttribute("id", 'category_name_input-'+id);
  input.setAttribute("value", value);


  var i= document.createElement('i');
  i.setAttribute("class", "fa fa-check");
  i.setAttribute("aria-hidden", "true");
  i.setAttribute("id", 'category_name_save-'+id);
  i.setAttribute("onclick", "save_name("+(id)+")");


  var i2= document.createElement('i');
  i2.setAttribute("class", "fa fa-times");
  i2.setAttribute("aria-hidden", "true");
  i2.setAttribute("onclick", "cancel_name("+(id)+", '"+(value)+"')");


  div.append(input);
  div.append(i);
  div.append(i2);
  div.classList.add('category_name_activated');
};
function cancel_name(id, value){
  div= document.getElementById('name-'+id);
  div.classList.remove('category_name_activated');

  while(div.firstChild){
      div.removeChild(div.firstChild);
  }


  var a = document.createElement('a');
  a.setAttribute("href", "/category/"+id);
  a.innerHTML=value;


  var i= document.createElement('i');
  i.setAttribute("class", "fa fa-pencil-square-o");
  i.setAttribute("aria-hidden", "true");
  i.setAttribute("onclick", "update_name("+(id)+", '"+(value)+"')");

  div.append(a);
  div.append(i);

}
function save_name(id){
  //loading
  lmnt=document.getElementById('category_name_save-'+id);
    start_loading(lmnt, "fa-floppy-o");

    //get new value
    value=document.getElementById('category_name_input-'+id).value;
    console.log(value);

    //get csrf and set headers
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
    });

    //create object
    var category = {};
    category.name = value;

    fetch("/"+locale+"/category/"+id, {
        method: 'PATCH',
        headers,
        body: JSON.stringify(category),
    }).then(function(response) {
        console.log(response);
        if (!response.ok) {
            if(response.status===422){
                response.json().then(data=>{
                    for (let i in data['errors']){
                        for (let j in data['errors'][i]) {
                            alert_warning(translate('validationFailed') + data['errors'][i][j]);
                            console.log(data['errors'][i][j][0]);

                        }
                    }
                    stop_loading(lmnt, "fa-floppy-o");
                })
            }else {
                throw Error(response.statusText);
            }
        }else{
            return response.json();
        }
    }).then(data => {
        // Work with JSON data here
         console.log(data);
        json_answer = data;
        stop_loading(lmnt, "fa-floppy-o");
        cancel_name(id, value);
        alert_success(data['message']);

    }).catch(function(error) {
         /*   console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);*/
        alert_warning(translate('problemConnecting') + error.message);
        stop_loading(lmnt, "fa-floppy-o");
    });

}
function change_category(id, parent_id, name="NoName"){
  //Set Action in field
  document.getElementById('selector-description-'+id).innerHTML=name;

  //get csrf and set headers
  const csrf = document.getElementsByName('_csrf-token')[0].content;
  const headers = new Headers({
      'X-CSRF-TOKEN': csrf,
      'Accept': 'application/json'
  });

  //create object
  var category = {};
  category.parent_id = parent_id;

  fetch("/"+locale+"/category/"+id, {
      method: 'PATCH',
      headers,
      body: JSON.stringify(category),
  }).then(function(response) {
      console.log(response);
      if (!response.ok) {
          if(response.status===422){
              response.json().then(data=>{
                  for (let i in data['errors']){
                      for (let j in data['errors'][i]) {
                          alert_warning(translate('validationFailed') + data['errors'][i][j]);
                          console.log(data['errors'][i][j][0]);

                      }
                  }
              })
          }else {
              throw Error(response.statusText);
          }
      }else{
          return response.json();
      }
  }).then(data => {
      // Work with JSON data here
       console.log(data);
      json_answer = data;
      alert_success(data['message']);
      location.reload();

  }).catch(function(error) {
       /*   console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);*/
      alert_warning(translate('problemConnecting') + error.message);
  });
}
function choose_category(id, parent_id, name="NoName"){
  //Set Action in field
  document.getElementById('selector-description-'+id).innerHTML=name;
  console.log('set value');
  document.getElementById('insert_parent_id').value=parent_id;

}
function create_name(name, parent_id){
  console.log('name: '+name.trim());
  if ( name.trim()!='' ){
    if( parent_id.trim()==''){
      parent_id=null;
    }else{
        parent_id=parent_id.trim();
    }
    //get csrf and set headers
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
    });

    //create object
    var category = {};
    category.name = name.trim();
    category.parent_id = parent_id;

    fetch("/"+locale+"/category", {
        method: 'PUT',
        headers,
        body: JSON.stringify(category),
    }).then(function(response) {
        console.log(response);
        if (!response.ok) {
            if(response.status===422){
                response.json().then(data=>{
                    for (let i in data['errors']){
                        for (let j in data['errors'][i]) {
                            alert_warning(translate('validationFailed') + data['errors'][i][j]);
                            console.log(data['errors'][i][j][0]);

                        }
                    }
                })
            }else if (response.status===400) {
              response.json().then(data=>{
                alert_warning(data['message']);

              })
            }else {
              throw Error(response.statusText);
            }
        }else{
            return response.json();
        }
    }).then(data => {
        // Work with JSON data here
        alert_success(data['message']);
        location.reload();

    }).catch(function(error) {
         /*   console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);*/
        alert_warning(translate('problemConnecting') + error);
    });
  }else{
    alert_warning('Name is empty');
  }

}
