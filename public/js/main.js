let buttons = document.getElementsByClassName('delete');
async function deleteAddress(event) {
    let address_id = event.target.id;
    let recordDB = 'http://localhost:80/address/delete/' + address_id;
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
    let url = 'http://localhost:80/address/get/' + email;
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

