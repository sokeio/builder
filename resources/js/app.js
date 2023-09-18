import { LiveWireGrapesJSModule } from "./modules/livewire-grapesjs";

window.addEventListener("byte::register", function () {
  ByteManager.registerPlugin(LiveWireGrapesJSModule);
});
