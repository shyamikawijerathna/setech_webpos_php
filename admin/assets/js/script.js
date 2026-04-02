function updateQty(btn, change) {
    const input = btn.parentNode.querySelector('input');
    let currentVal = parseInt(input.value);
    if (currentVal + change >= 1) {
        input.value = currentVal + change;
    }
    // You would normally add logic here to recalculate totals
}

function numPress(val) {
    console.log("Pressed: " + val);
    // Logic to enter data into the search bar or quantity
}