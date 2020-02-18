const entreprises = document.getElementById('entreprises');

if (entreprises) {
    entreprises.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete-ent') {
            if (confirm('Supprimer Entreprise ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/entreprise/destroy/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}