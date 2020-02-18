const projets = document.getElementById('projets');

if (projets) {
    projets.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete-projet') {
            if (confirm('Supprimer Projet ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/projet/destroy/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}