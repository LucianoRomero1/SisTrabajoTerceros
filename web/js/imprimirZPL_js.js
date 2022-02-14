var selected_device="";
function setup()
{
    //Get the default device from the application as a first step. Discovery takes longer to complete.
    BrowserPrint.getDefaultDevice("printer", function(device)
    {                
        //Add device to list of devices and to html select element
        selected_device = device;

        $('#footer-3').html("Impresora: " + device.name);

    }, function(error){
        $('#footer-3').html("No existe Impresora");
        //Evita el msg al iniciar donde no existe impresora
        //alert(error);
    })
}

function writeToSelectedPrinter(dataToWrite)
{
    if (typeof selected_device.name === "undefined")
    {
        $('#footer-3').html("No existe Impresora");
        return 0;
    }
    else
    {
        $('#footer-3').html("Impresora: " + selected_device.name + " Imprimiendo....");
        selected_device.send(dataToWrite, undefined, errorCallback);
        $('#footer-3').html("Impresora: " + selected_device.name );
        return 1;
    }
    
}

var errorCallback = function(errorMessage){
    alert("Error: " + errorMessage);
    $('#footer-3').html(selected_device.name );
}

window.onload = setup;
