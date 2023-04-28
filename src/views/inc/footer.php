<!-- Footer -->
<footer class="bg-light py-3">
        <div class="container text-center">
            <p>Site de Covoiturage &copy; 2023</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
    integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
    integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
</script>
<script>
  function submitForm(event) {
    event.preventDefault(); // Empêche le comportement par défaut de soumission du formulaire
    const form = event.target;
    const formData = new FormData(form);
    fetch(form.action, {
        method: form.method,
        body: formData
      })
      .then(response => response.text())
      .then(html => {
        const resultContainer = document.getElementById('result');
        resultContainer.innerHTML = html;
      });
  }


  function calculePrix() {
  const nombre = document.getElementById('nombrePlace').value;
  const prix_place = <?= $voyage->prix_place ?>;
  const prix_total = nombre * prix_place;
  document.getElementById('prix').innerHTML = 'Prix totale : ' + prix_total + ' FCFA';
}
</script>

</body>
</html>