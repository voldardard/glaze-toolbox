function update_name(id, value){
  var div= document.getElementById('name-'+id);
  while(div.firstChild){
      div.removeChild(div.firstChild);
  }
  var input = document.createElement('input');
  input.setAttribute("required", "required");
  input.setAttribute("type", "text");
  input.setAttribute("placeholder", 'Category name');
  input.setAttribute("id", 'label_name_input-'+id);
  input.setAttribute("value", value);


  var i= document.createElement('i');
  i.setAttribute("class", "fa fa-check");
  i.setAttribute("aria-hidden", "true");
  i.setAttribute("id", 'label_name_save-'+id);
  i.setAttribute("onclick", "save_name("+(id)+")");


  var i2= document.createElement('i');
  i2.setAttribute("class", "fa fa-times");
  i2.setAttribute("aria-hidden", "true");
  i2.setAttribute("onclick", "cancel_name("+(id)+", '"+(value)+"')");


  div.append(input);
  div.append(i);
  div.append(i2);
  div.classList.add('label_name_activated');
};
function cancel_name(id, value){
  var div= document.getElementById('name-'+id);
  div.classList.remove('label_name_activated');

  while(div.firstChild){
      div.removeChild(div.firstChild);
  }


  var a = document.createElement('a');
  a.setAttribute("href", "/label/"+id);
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
  var lmnt=document.getElementById('label_name_save-'+id);
    start_loading(lmnt, "fa-floppy-o");

    //get new value
    var value=document.getElementById('label_name_input-'+id).value;
    console.log(value);

    //get csrf and set headers
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
    });

    //create object
    var label = {};
    label.name = value;

    fetch("/"+locale+"/label/"+id, {
        method: 'PATCH',
        headers,
        body: JSON.stringify(label),
    }).then(function(response) {
      console.log(response);
      if (!response.ok) {
          if(response.status===422){
            return response.json().then(data=>{
              for (let i in data['errors']){
                  for (let j in data['errors'][i]) {
                      alert_warning(translate('validationFailed') + data['errors'][i][j]);
                      console.log(data['errors'][i][j][0]);

                  }
              }
              throw new Error('Error validating data');
            });
          }else {
            return response.json().then(data=>{
              console.log(data);
              if(data['message']){
                throw new Error(data['message']);
              }else{
                throw new Error(translate('problemConnecting') +response.statusText);
              }
            });

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
         alert_warning(error.message);
        stop_loading(lmnt, "fa-floppy-o");
    });

}

function create_name(name){
  console.log('name: '+name.trim());
  if ( name.trim()!='' ){

    //get csrf and set headers
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
    });

    //create object
    var label = {};
    label.name = name.trim();

    fetch("/"+locale+"/label", {
        method: 'PUT',
        headers,
        body: JSON.stringify(label),
    }).then(function(response) {
        console.log(response);
        if (!response.ok) {
            if(response.status===422){
              return response.json().then(data=>{
                for (let i in data['errors']){
                    for (let j in data['errors'][i]) {
                        alert_warning(translate('validationFailed') + data['errors'][i][j]);
                        console.log(data['errors'][i][j][0]);

                    }
                }
                throw new Error(data['message']);
              });
            }else {
              return response.json().then(data=>{
                console.log(data);
                if(data['message']){
                  throw new Error(data['message']);
                }else{
                  throw new Error(translate('problemConnecting') +response.statusText);
                }
              });

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
        alert_warning(error.message);
    });
  }else{
    alert_warning('Name is empty');
  }

}
function delete_label(id){

  //get csrf and set headers
  const csrf = document.getElementsByName('_csrf-token')[0].content;
  const headers = new Headers({
      'X-CSRF-TOKEN': csrf,
      'Accept': 'application/json'
  });

  fetch("/"+locale+"/label/"+id, {
      method: 'DELETE',
      headers,
  }).then(function(response) {
      console.log(response);
      if (!response.ok) {
          if(response.status===422){
            return response.json().then(data=>{
              for (let i in data['errors']){
                  for (let j in data['errors'][i]) {
                      alert_warning("Dependance failed: " + data['errors'][i][j]);
                      console.log(data['errors'][i][j][0]);

                  }
              }
              throw new Error(data['message']);
            });
          }else {
            return response.json().then(data=>{
              console.log(data);
              if(data['message']){
                throw new Error(data['message']);
              }else{
                throw new Error(translate('problemConnecting') +response.statusText);
              }
            });

          }
      }else{
          return response.json();
      }
  }).then(data => {
      // Work with JSON data here
      //console.log(data['message']);
      //console.log(data);

      alert_success(data['message']);
      location.reload();

  }).catch(function(error) {
       /*   console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);*/
      alert_warning(error.message);
  });

}