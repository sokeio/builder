import openImport from "./openImport";
import shortcode from "./shortcode";
import device from "./device";
export default (editor, opts = {}) => {
  openImport(editor, opts);
  shortcode(editor, opts);
  device(editor, opts);
};
