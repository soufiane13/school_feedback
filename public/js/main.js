
// Attend que le document soit prêt
document.addEventListener('DOMContentLoaded', function() {

    // S'occupe de tous les systèmes d'étoiles 
    document.querySelectorAll('.star-rating').forEach(function(starGroup) {
        
        const stars = starGroup.querySelectorAll('.star');
        // Trouve l'input caché correspondant
        const input = starGroup.nextElementSibling; 

        stars.forEach(function(star) {
            
            // --- GESTION DU CLIC ---
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                
                // Met à jour la valeur de l'input caché
                input.value = value;
                
                // Réinitialise la classe 'selected'
                stars.forEach(s => s.classList.remove('selected'));
                
                // Ajoute la classe 'selected' à l'étoile cliquée
                this.classList.add('selected');
                
                
            });
        });
    });

    // --- GESTION DE LA CONFIRMATION  ---
    const form = document.getElementById('feedbackForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const confirmation = document.getElementById('confirmation-message');
            if (confirmation) {
                confirmation.style.display = 'block';
            }
        });
    }

});