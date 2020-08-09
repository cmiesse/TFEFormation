

var commonRouteObj = new Object();
commonRouteObj["id"] = $('#clientID').text();

modalRemove("deleteContract", "modalDeleteContract", "messageModal", "tic_platform_contracts_delete", 0, "idContract", "contractID", commonRouteObj);