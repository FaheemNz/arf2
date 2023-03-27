$(function () {
    $("#has_laptop").click(function () {
        if ($("#has_laptop").is(":checked")) {
            $("#laptop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_laptop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#laptop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_laptop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_tablet").click(function () {
        if ($("#has_tablet").is(":checked")) {
            $("#tablet-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_tablet_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#tablet-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_tablet_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_sim").click(function () {
        if ($("#has_sim").is(":checked")) {
            $("#sim-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_sim_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#sim-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_sim_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_desktop").click(function () {
        if ($("#has_desktop").is(":checked")) {
            $("#desktop-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_desktop_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#desktop-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_desktop_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_monitor").click(function () {
        if ($("#has_monitor").is(":checked")) {
            $("#monitor-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_monitor_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#monitor-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_monitor_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#has_mobile").click(function () {
        if ($("#has_mobile").is(":checked")) {
            $("#mobile-row").find(".arf-toggle-input").removeAttr("disabled");
            $("#btn_arf_mobile_search")
                .prop("disabled", false)
                .css("pointer-events", "all");
        } else {
            $("#mobile-row").find(".arf-toggle-input").attr("disabled", true);
            $("#btn_arf_mobile_search")
                .prop("disabled", true)
                .css("pointer-events", "none");
        }
    });

    $("#arf-name").on("change", function () {
        if ($(this).val()) {
            $("#signature-name").text($(this).val());
            $("#arf-email").val(
                $(this).val()
                    .split(" ")
                    .join(".")
                    .toLowerCase() +
                    "@azizidevelopments.com"
            );
        }
    });
});

let modal = new bootstrap.Modal(document.getElementById("asset-search-modal"));

$(document).on("click", ".searchModalTrigger", function () {
    let tableName = $(this).attr("data-table"),
        assetCode = $(this).attr("data-field-asset-code"),
        assetBrand = $(this).attr("data-field-brand");

    if (!tableName || !assetCode || !assetBrand) {
        console.log(tableName, assetCode, assetBrand);
        
        alert("Script Parsing Issue.");
        
        return;
    }

    searchModalTrigger(tableName, assetCode, assetBrand);
});

function searchModalTrigger(tableName, assetCode, assetBrand) {
    $("#table").val(tableName);
    $("#c_asset_code").val(assetCode);
    $("#c_brand").val(assetBrand);
    $("#is-available").addClass("d-none");

    let assetTypeAjax = $("#asset_code_ajax");

    assetTypeAjax.empty();

    $.ajax({
        method: "GET",
        url: "/search-asset-availability",
        data: {
            table: tableName
        },
        success: function (response) {
           if(response.success == true){
                assetTypeAjax.append(`<option value="">Select</option>`);

                response.data.forEach(asset => {
                    assetTypeAjax.append(`<option data-brand="${asset.asset_brand}" data-table="${response.type}" value="${asset.asset_code}">${asset.asset_code}</option>`)
                });
           } else {
                assetTypeAjax.append(`<option value="">No Asset Found</option>`);
                alert("No Asset is Available");
           }
        },
        error: function (error) {
            console.log(error);

            alert("Some Error Occured");
        },
    });
    
    modal.show();
}

function fillAssetDetails(){
    let fromAjaxAsset = $("#asset_code_ajax");

    if(!fromAjaxAsset.val()){
        alert("Please select a valid asset");
        
        return;
    }

    let theCode = fromAjaxAsset.val(),
        theBrand = $("#asset_code_ajax option:selected").attr("data-brand"),
        table = $("#asset_code_ajax option:selected").attr("data-table");

    console.log(theCode, theBrand, table);
    
    if(!theCode || !theBrand || !table){
        alert("Some Error Occured");

        return;
    }

    $("#arf_" + table + "_asset_code").val( theCode );
    $("#arf_" + table + "_brand").val( theBrand );

    modal.hide();
}

function preSelectOfficeLocation(deptId) {
    let officeLocations = [
        { dept_id: 1, floor: 2 }, // Asset        => 8
        { dept_id: 2, floor: 1 }, // Audit        => 5,
        { dept_id: 3, floor: 2 }, // CRM          => 8
        { dept_id: 4, floor: 5 }, // VCM          => 14
        { dept_id: 5, floor: 5 }, // Sales        => 14
        { dept_id: 6, floor: 5 }, // S.Admin      => 14
        { dept_id: 7, floor: 6 }, // Techtiq      => 15
        { dept_id: 8, floor: 6 }, // Legacious    => 15
        { dept_id: 9, floor: 6 }, // Eng          => 15,
        { dept_id: 10, floor: 6 }, // PMO          => 15,
        { dept_id: 11, floor: 6 }, // Gardinia     => 15,
        { dept_id: 12, floor: 5 }, // Procurement  => 14,
        { dept_id: 13, floor: 1 }, // Finance      => 5,
        { dept_id: 14, floor: 2 }, // Handover     => 8,
        { dept_id: 15, floor: 4 }, // Agency       => 13,
        { dept_id: 16, floor: 4 }, // Telesales    => 13,
        { dept_id: 17, floor: 4 }, // Marketing    => 13,
        { dept_id: 18, floor: 5 }, // Agency       => 13,
        { dept_id: 19, floor: 2 }, // Admin        => 8,
        { dept_id: 20, floor: 2 }, // Operation    => 8,
    ];

    if (!deptId) {
        return;
    }

    let theOffice = officeLocations.find((o) => o.dept_id == deptId).floor;

    $("#arf_office_location option[value=" + theOffice + "]").prop(
        "selected",
        true
    );
}

function loadBrands(elem){
    let type = elem.value,
        assetBrand = $("#asset_brand");

    if(!type){
        return;
    }

    assetBrand.empty();

    $.ajax({
        url: "/get-brands",
        method: "GET",
        data: {
            type: type
        },
        success: function(response){
            if(response.success == true){
                assetBrand.append(`<option value="">Select</option>`);
                response.data.forEach(brand => {
                    assetBrand.append(`<option value="${brand}">${brand}</option>`);
                });
            } else {
                alert("No Brand found");
            }
        },
        error: function(error){
            console.log(error);

            alert("Some Error Occured. Please try again later")
        }
    });
}
