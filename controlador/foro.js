
const quill = new Quill('#editor', {
    placeholder: 'Escribí el contenido aca ',
  modules: {
    toolbar: [
      ['bold', 'italic'],
      ['link', 'blockquote', 'code-block'],
    ],
  },
  theme: 'snow',
});

const form = document.querySelector('#publicacion');
form.addEventListener('submit', function(e) {
 document.querySelector('#cuerpo').value = quill.root.innerHTML;
});