export default (editor, opts = {}) => {
  const domc = editor.DomComponents;
  var shortcodeRegex = /\[([\w-:]+)((?:\s+\w+\s*=\s*"[^"]*")*)\](.*?)\[\/\1\]/s;

  domc.addType("shortcode", {
    isComponent: (el) =>
      el.tagName === "DIV" &&
      el.childElementCount == 0 &&
      shortcodeRegex.test(el.innerHTML),
    model: {
      defaults: {
        tagName: "",
        name: "shortcode",
        draggable: true,
        droppable: false,
        removed: false,
        content: '<div data-gjs-type="shortcode"></div>',
      },
    },

    view: {
      async onRender({ model }) {
        let html = this.el.innerHTML;
        if (shortcodeRegex.test(html) || shortcodeRegex.test(model.content)) {
          let $wireId = Alpine.closestRoot(
            editor.editorView.$el[0]
          )?.getAttribute("wire:id");
          if ($wireId) {
            console.log(this);
            let shortcode = this.el.innerHTML;
            if (shortcodeRegex.test(model.content)) {
              shortcode = model.content;
            }
            let content = await Livewire.find($wireId).ConvertShortcodeToHtml(
              shortcode
            );
            this.el.innerHTML = `<div data-gjs-type="shortcode">${content}</div>`;
            this.el.setAttribute(
              "data-shortcode",
              encodeURIComponent(
                '<div data-gjs-type="shortcode">' + html + "</div>"
              )
            );
          }
        }
      },
    },
  });
  editor.on("component:styleUpdate", function (model) {
    if (model && model.get("type") === "shortcode") {
      // Áp dụng kiểu CSS cho thành phần block shortcode trong canvas
      model.set({
        style: {
          "min-height": "50px",
          padding: "20px",
          border: "1px dashed #ccc",
          // Các thuộc tính style khác tùy ý
        },
      });
    }
  });
};
