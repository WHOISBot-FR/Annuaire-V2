document.getElementById('search-bar').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        let name = card.querySelector('h2').innerText.toLowerCase();
        card.style.display = name.includes(filter) ? '' : 'none';
    });
});
