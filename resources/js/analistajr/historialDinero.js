fetch('/api/transacciones')
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);

            



        })
        .catch(error => {
            console.error('Error:', error);
        });
