
let href = window.location.href;
let arr = href.split('/');
let hostName = arr[0] + "//" + arr[2];

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
