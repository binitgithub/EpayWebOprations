var BusinessId;
var selectedArray = new Array();
$(document).ready(function () {

    $.LoadingOverlay("show");//show ajax loader
    BusinessId = localStorage.getItem("businessId");
    //localStorage.removeItem("businessId");

    $.ajax({
        url: apiBaseUrl + "Business/" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                $("#BusinessName").text(info.DisplayName);
            }
            else {
                alertify.warning("No business found");
            }
        },
        error: function (err) {
            alertify.error("Something went wrong, try again");
        },
        complete: function () {
            $.LoadingOverlay("hide");//hide ajax loader
        }
    });

    $.ajax({
        url: apiBaseUrl + "BusinessConfigs/Business?businessId=" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data.bc;
                $("#admin-email").val(info.AdminEmail);
                $("#min-acc-number-length").val(info.MinAccountNumberLength);
                $("#max-acc-number-length").val(info.MaxAccountNumberLength);

                if (info.HasAgents == true) {
                    $("#has-agents").prop('checked', true);
                }
                else {
                    $("#has-agents").prop('checked', false);
                }

                if (info.UsingEpayPIN == true) {
                    $("#using-epay-pin").prop('checked', true);
                }
                else {
                    $("#using-epay-pin").prop('checked', false);
                }

                if (info.UsingUniversalPIN == true) {
                    $("#using-universal-pin").prop('checked', true);
                }
                else {
                    $("#using-universal-pin").prop('checked', false);
                }

                if (info.BillNumberValidation == true) {
                    $("#bill-no-validation").prop('checked', true);
                }
                else {
                    $("#bill-no-validation").prop('checked', false);
                }

                $("#website").val(info.Website);
                $("#phone-number").val(info.PhoneNumber);
                $("#contact-email").val(info.ContactEmail);
                $("#internal-system-name").val(info.InternalSystemName);
                $("#internal-system-base-address").val(info.InternalSystemBaseAddress);
                $("#user-linkage-fields").val(info.UserAccountLinkageFields);
                $("#acc-no-format").val(info.AccountNumberFormat);
                $("#internal-account-names").val(info.InternalAccountNames);
                $("#info1").val(info.AdditionalInfo1);
                $("#info2").val(info.AdditionalInfo2);
                $("#info3").val(info.AdditionalInfo3);
                $("#info4").val(info.AdditionalInfo4);

                if (info.HasTip == true) {
                    $("#has-tip").prop('checked', true);
                }
                else {
                    $("#has-tip").prop('checked', false);
                }

                $("#tip-account-name").val(info.TipAccountName);
                $("#tip-account-number").val(info.TipAccountNumber);
                $("#tip-account-fi-name").val(info.TipAccountFIName);
                $("#tip-account-businessid").val(info.TipAccountBusinessId);
                $("#tip-wallet-id").val(info.TipWalletId);
            }
            else {
                alertify.warning("No alertify found");
            }
        },
        error: function (err) {
            alertify.error("Something went wrong, try again");
        },
        complete: function () {
            $.LoadingOverlay("hide");//hide ajax loader
        }
    });    

});

$(function () {

    //EDIT AGENT (Submit Update)
    $("#Reset").click(function () {
        emptyInfo();
        fillInfo();
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {            

        if ($("#has-agents").is(':checked')){
            HasAgents = true;
        }
        else {
            HasAgents = false;
        }

        if ($("#using-epay-pin").is(':checked')){
            UsingEpayPIN = true;
        }
        else {
            UsingEpayPIN = false;
        }

        if ($("#using-universal-pin").is(':checked')){
            UsingUniversalPIN = true;
        }
        else {
            UsingUniversalPIN = false;
        }

        if ($("#bill-no-validation").is(':checked')){
            BillNumberValidation = true;
        }
        else {
            BillNumberValidation = false;
        }

        if ($("#has-tip").is(':checked')){
            HasTip = true;
        }
        else {
            HasTip = false;
        }

        AdminEmail = $("#admin-email").val();
        MinAccountNumberLength = $("#min-acc-number-length").val();
        MaxAccountNumberLength = $("#max-acc-number-length").val();
        Website = $("#website").val();
        PhoneNumber = $("#phone-number").val();
        ContactEmail = $("#contact-email").val();
        InternalSystemName = $("#internal-system-name").val();
        InternalSystemBaseAddress = $("#internal-system-base-address").val();
        UserAccountLinkageFields = $("#user-linkage-fields").val();
        AccountNumberFormat = $("#acc-no-format").val();
        InternalAccountNames = $("#internal-account-names").val();
        AdditionalInfo1 = $("#info1").val();
        AdditionalInfo2 = $("#info2").val();
        AdditionalInfo3 = $("#info3").val();
        AdditionalInfo4 = $("#info4").val();
        TipAccountName = $("#tip-account-name").val();
        TipAccountNumber = $("#tip-account-number").val();
        TipAccountFIName = $("#tip-account-fi-name").val();
        TipAccountBusinessId = $("#tip-account-businessid").val();
        TipWalletId = $("#tip-wallet-id").val(); 

        var businessDetails = {
            BusinessId: BusinessId,
            //AdminRoleId: AdminRoleId,
            AdminEmail: AdminEmail,
            MinAccountNumberLength: MinAccountNumberLength,
            MaxAccountNumberLength: MaxAccountNumberLength,
            HasAgents: HasAgents,//
            UsingEpayPIN: UsingEpayPIN,
            UsingUniversalPIN: UsingUniversalPIN,
            BillNumberValidation: BillNumberValidation,//
            Website: Website,
            PhoneNumber: PhoneNumber,
            ContactEmail: ContactEmail,
            InternalSystemName: InternalSystemName,
            InternalSystemBaseAddress: InternalSystemBaseAddress,
            UserAccountLinkageFields: UserAccountLinkageFields,
            AccountNumberFormat: AccountNumberFormat,
            InternalAccountNames: InternalAccountNames,
            AdditionalInfo1: AdditionalInfo1,
            AdditionalInfo2: AdditionalInfo2,
            AdditionalInfo3: AdditionalInfo3,
            AdditionalInfo4: AdditionalInfo4,
            HasTip: HasTip,//
            TipAccountName: TipAccountName,
            TipAccountNumber: TipAccountNumber,
            TipAccountFIName: TipAccountFIName,
            TipAccountBusinessId: TipAccountBusinessId,
            TipWalletId: TipWalletId,
        };

        businessDetails = JSON.stringify(businessDetails);

        $.ajax({
            url: apiBaseUrl + "AdminPortal/UpdateNewBusinessConfig",
            crossDomain: true,
            dataType: "json",
            method: "POST",
            contentType: "application/json; charset=UTF-8",
            data: businessDetails,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function (data) {
                if (data.status) {
                    alertify.success("Business Updated.");

                    window.location.href = "dashboard.php";
                }
                else {
                    alertify.error(data.message);
                }
            },
            error: function (err) {
                alertify.error("Something went wrong <br/>");
            },
            complete: function () {
                //$('#edit-agent-modal').modal('show');
            }
        });
    });

})

function emptyInfo() {
    $("#admin-email").val("");
    $("#min-acc-number-length").val("");
    $("#max-acc-number-length").val("");
    $("#has-agents").prop('checked', false);
    $("#using-epay-pin").prop('checked', false);
    $("#using-universal-pin").prop('checked', false);
    $("#bill-no-validation").prop('checked', false);
    $("#website").val("");
    $("#phone-number").val("");
    $("#contact-email").val("");
    $("#internal-system-name").val("");
    $("#internal-system-base-address").val("");
    $("#user-linkage-fields").val("");
    $("#acc-no-format").val("");
    $("#internal-account-names").val("");
    $("#info1").val("");
    $("#info2").val("");
    $("#info3").val("");
    $("#info4").val("");
    $("#has-tip").prop('checked', false);
    $("#tip-account-name").val("");
    $("#tip-account-number").val("");
    $("#tip-account-fi-name").val("");
    $("#tip-account-businessid").val("");
    $("#tip-wallet-id").val("");
}

function fillInfo() {

    $.ajax({
        url: apiBaseUrl + "BusinessConfigs/Business?businessId=" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data.bc;
                $("#admin-email").val(info.AdminEmail);
                $("#min-acc-number-length").val(info.MinAccountNumberLength);
                $("#max-acc-number-length").val(info.MaxAccountNumberLength);

                if (info.HasAgents == true) {
                    $("#has-agents").prop('checked', true);
                }
                else {
                    $("#has-agents").prop('checked', false);
                }

                if (info.UsingEpayPIN == true) {
                    $("#using-epay-pin").prop('checked', true);
                }
                else {
                    $("#using-epay-pin").prop('checked', false);
                }

                if (info.UsingUniversalPIN == true) {
                    $("#using-universal-pin").prop('checked', true);
                }
                else {
                    $("#using-universal-pin").prop('checked', false);
                }

                if (info.BillNumberValidation == true) {
                    $("#bill-no-validation").prop('checked', true);
                }
                else {
                    $("#bill-no-validation").prop('checked', false);
                }

                $("#website").val(info.Website);
                $("#phone-number").val(info.PhoneNumber);
                $("#contact-email").val(info.ContactEmail);
                $("#internal-system-name").val(info.InternalSystemName);
                $("#internal-system-base-address").val(info.InternalSystemBaseAddress);
                $("#user-linkage-fields").val(info.UserAccountLinkageFields);
                $("#acc-no-format").val(info.AccountNumberFormat);
                $("#internal-account-names").val(info.InternalAccountNames);
                $("#info1").val(info.AdditionalInfo1);
                $("#info2").val(info.AdditionalInfo2);
                $("#info3").val(info.AdditionalInfo3);
                $("#info4").val(info.AdditionalInfo4);

                if (info.HasTip == true) {
                    $("#has-tip").prop('checked', true);
                }
                else {
                    $("#has-tip").prop('checked', false);
                }

                $("#tip-account-name").val(info.TipAccountName);
                $("#tip-account-number").val(info.TipAccountNumber);
                $("#tip-account-fi-name").val(info.TipAccountFIName);
                $("#tip-account-businessid").val(info.TipAccountBusinessId);
                $("#tip-wallet-id").val(info.TipWalletId);
            }
            else {
                alertify.warning("No alertify found");
            }
        },
        error: function (err) {
            alertify.error("Something went wrong, try again");
        },
        complete: function () {
            $.LoadingOverlay("hide");//hide ajax loader
        }
    }); 
}