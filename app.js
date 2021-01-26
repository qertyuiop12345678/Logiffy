const webhook_box = document.getElementById('webhook');
const create_btn = document.getElementById('create');
const copy_btn = document.getElementById('copy')

create_btn.addEventListener("click", async function(event) {
    event.preventDefault()

    let webhook = webhook_box.value
    let data = await fetch('./create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'webhook': webhook
        })
    })
    await data
    data = await data.text()
    await data

    if (data) {
        webhook_box.value = data;
    }
});

copy_btn.addEventListener('click', async function(event) {
    event.preventDefault()
    webhook_box.select()
    webhook_box.setSelectionRange(0,99999)
    document.execCommand('copy')
})
