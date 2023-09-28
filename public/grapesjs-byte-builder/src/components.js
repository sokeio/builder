export default (editor, opts = {}) => {
  const domc = editor.DomComponents;
  var shortcodeRegex = /\[([\w-:]+)((?:\s+\w+\s*=\s*"[^"]*")*)\](.*?)\[\/\1\]/s;

  domc.addType("shortcode", {
    isComponent: (el) =>
      el.tagName === "DIV" && shortcodeRegex.test(el.innerHTML),
    model: {
      defaults: {
        tagName: "",
        name: "Shortcode",
        draggable: true,
        droppable: false,
        removed: false,
        content: '<div data-gjs-type="shortcode"></div>',
        components: "",
      },
    },
    // toHTML: function () {
    //   // Xử lý việc render HTML cho thành phần shortcode
    //   var content = this.get("content");
    //   var name = content.substring(6, content.length - 8);
    //   return "Test thử";
    // },
    view: {},
  });
  editor.on("component:styleUpdate", function (model) {
    if (model && model.get("type") === "shortcode") {
      // Áp dụng kiểu CSS cho thành phần block shortcode trong canvas
      model.set({
        style: {
          "min-height": "50px",
          padding: "10px",
          border: "1px dashed #ccc",
          // Các thuộc tính style khác tùy ý
        },
      });
    }
  });
};
