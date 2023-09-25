import loadComponents from "./components";
import loadPanels from "./panels";
import loadCommands from "./commands";
import loadBlocks from "./blocks";
import en from "./locale/en";

export default (editor, opts = {}) => {
  const options = {
    ...{
      i18n: {},
      // default options
    },
    modalImportTitle: "Import",
    modalImportButton: "Import",
    modalImportLabel: "",
    modalImportContent: "",
    importViewerOptions: {},
    textCleanCanvas: "Are you sure you want to clear the canvas?",
    showStylesOnChange: true,
    useCustomTheme: true,
    ...opts,
  };
  // Add panels
  loadPanels(editor, options);
  // Add commands
  loadCommands(editor, options);
  // Add components
  loadComponents(editor, options);
  // Add blocks
  loadBlocks(editor, options);
  // Load i18n files
  editor.I18n &&
    editor.I18n.addMessages({
      en,
      ...options.i18n,
    });

  editor.on("component:selected", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  editor.on("block:drag:stop", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  // TODO Remove
  // editor.on('load', () =>
  //   editor.addComponents(
  //       `<div style="margin:100px; padding:25px;">
  //           Content loaded from the plugin
  //       </div>`,
  //       { at: 0 }
  //   ))
};
