const url = 'http://localhost/Code%20Test/PT%20Medika%20Digitak%20Nusantara/handle.php';

// fetch to index() in Parking Class
document.addEventListener("DOMContentLoaded", event => { 
  fetch(url, {
    method: 'GET',
    mode:"cors",
    headers: {
      "Content-Type": "application/json"
    }
  })
  .then(response => {
    return response.json()
  })
  .then(body =>{
    let data = body.data;
    let table = document.querySelector('#table-body');
    data.forEach(element => {
      let nDate = new Date(element.in_time * 1000);
      let date = `${nDate.getDay()}-${nDate.getMonth()}-${nDate.getFullYear()} ${nDate.getHours()}:${nDate.getMinutes()}`;
      table.innerHTML += createTable(element.id, date);
    });
  })
  .catch(err =>{
    return new Error(err.message);
  })
});

// fetch API to setTimeIn() in Parking Class
function inputTimeIn(){
  let value = document.querySelector('#in-time').value;
  let data = {"in_time": value};
  if(checkSubmit(value, "in")){
    fetch(url, {
      method: 'POST',
      mode:"cors",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json"
      }
    })
    .then(response =>{
      return response.json()
    })
    .then(body =>{
      if(body.message){
        alert(body.message);
        return;
      }
      let data = body.data;
      let table = document.querySelector('#table-body');
      let nDate = new Date(body.data.in_time * 1000);
      let date = `${nDate.getDay()}-${nDate.getMonth()}-${nDate.getFullYear()} ${nDate.getHours()}:${nDate.getMinutes()}`;
      table.innerHTML += createTable(data.id, date);
    })
    .catch(function(err){
      return new Error(err.message);
    })
  }
}

//fetch API to totalTime in Parking Class
function inputTimeOut(id){
  let value = document.querySelector(`#out-time-${id}`).value;
  let data = {"out_time": value, 'id': id};
  if(checkSubmit(value, "out")){
    fetch(url, {
      method: 'POST',
      mode:"cors",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json"
      }
    })
    .then(response =>{
      return response.json()
    })
    .then(body => {
      if(body.message){
        alert(body.message);
        return;
      }
      alert(`Your Payment is ${body.payment}`);
      document.querySelector("#row-"+id).remove();
    })
    .catch(err =>{
      return new Error(err.message);
    })
  }
}

// validation if input is empty
function checkSubmit(value, message)
{
  if(value == ""){
    alert(`insert time ${message}!`);
    return false;
  }

  return true;
}

// create row
function createTable(id, date){
  row = `<tr id="row-${id}"> 
        <td>${id}</td>      
        <td>${date}</td>
        <td>
          <form method="POST">
          <input type="time" name="out_time" id="out-time-${id}">
          <button onclick="event.preventDefault(); inputTimeOut(${id})">Out</button>
          </form>
        </td>
        </tr>`;

  return row;
}
