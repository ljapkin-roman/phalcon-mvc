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

