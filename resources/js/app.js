import { LiveWireGrapesJSModule } from "./modules/livewire-grapesjs";

window.addEventListener("sokeio::register", function () {
  ByteManager.registerPlugin(LiveWireGrapesJSModule);
});
