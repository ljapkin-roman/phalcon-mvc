let buttons = document.getElementsByClassName('delete');

let href = window.location.href;
let arr = href.split('/');
let hostName = arr[0] + "//" + arr[2];

async function deleteAddress(event) {
    let address_id = event.target.id;
    let recordDB = hostName + '/address/delete/' + address_id;
    let response = await fetch(recordDB);
    let result = await response.json();
    console.log(result);
}
for (let button of buttons) {
    button.addEventListener("click", deleteAddress);
}

$(".chosen-select").chosen();

let selectUser = document.getElementById("selectUser");

async function createTable(email='')
{
    let url = hostName + '/address/get/' + email;
    url = url.replace(/\s/g, '');
    let response = await fetch(url);
    let listAddress = await response.json();
    let tableBody = document.getElementById('parentBody');
    tableBody.innerHTML = '';
    for(let key in listAddress) {
        addRecord(tableBody, key, listAddress[key]);
    } 
}
createTable();
function addRecord(table, key, address)
{
        let tr = document.createElement('tr')
        let innerHtml = 
            "<th>" +  address['city'] + "</th>" +
            "<th>" +  address['region'] + "</th>" +
            "<th>" +  address['street'] + "</th>" +
            "<th>" +  address['postcode'] + "</th>" +
            "<th>" +  address['owner']  + "</th>";
        tr.innerHTML = innerHtml;
        table.append(tr);
}


function getAddressUser(user)
{
    let email = user.options[user.selectedIndex].innerHTML;
    if (email == 'all') {
        email = '';
    }
    createTable(email);
}

