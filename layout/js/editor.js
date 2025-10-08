const quill = new Quill("#quill-editor", {
  theme: "snow",
  modules: {
    toolbar: [
      ["bold", "italic", "underline", "strike"],
      [
        {
          size: ["small", false, "large", "huge"],
        },
      ],
      [
        {
          color: [],
        },
        {
          background: [],
        },
      ],
      [
        {
          align: [],
        },
      ],
      [
        {
          list: "ordered",
        },
        {
          list: "bullet",
        },
      ],
      ["blockquote", "code-block"],
      ["link", "image"],
      ["clean"],
    ],
  },
});

const form = document.querySelector('form[method="post"]');
form.addEventListener("submit", function () {
  document.getElementById("hidden-editor-content").value = quill.root.innerHTML;
});
