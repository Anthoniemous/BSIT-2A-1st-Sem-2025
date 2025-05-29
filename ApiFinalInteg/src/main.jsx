import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./assets/css/output.css";
import Application from "./components/Application";

createRoot(document.getElementById("root")).render(
  <StrictMode>
    <Application />
  </StrictMode>
);
