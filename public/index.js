import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

import gridOptions from "../gridOptions";
import * as printParams from "./PDFExportPanel";

import getDocDefinition from "./docDefinition";

pdfMake.vfs = pdfFonts.pdfMake.vfs;

function printDoc() {
    console.log("Exporting to PDF...");
    const docDefinition = getDocDefinition(
        printParams,
        gridOptions.api,
        gridOptions.columnApi
    );
    pdfMake.createPdf(docDefinition).download();
}

export default printDoc;
