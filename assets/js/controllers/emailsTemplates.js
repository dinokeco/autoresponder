class EmailTemplate{

  static init(){
    $("#add-email-template").validate({
      submitHandler: function(form, event) {
        event.preventDefault();
        var data = AUtils.form2json($(form));
        if (data.id){
          EmailTemplate.update(data);
        }else{
          EmailTemplate.add(data);
        }
      }
    });
    AUtils.role_based_elements();
    EmailTemplate.get_all();
    EmailTemplate.chart();
  }

  static chart(){
    RestClient.get("api/user/email_templates_chart", function(chart_data){
      new Morris.Line({
        element: 'email-chart-container',
        data: chart_data,
        xkey: 'year',
        ykeys: ['value'],
        labels: ['Value']
      });
    });
  }

  static get_all(){
    $("#email-templates-table").DataTable({
      processing: true,
      serverSide: true,
      bDestroy: true,
      pagingType: "simple",
      preDrawCallback: function( settings ) {
        if (settings.aoData.length < settings._iDisplayLength){
          //disable pagination
          settings._iRecordsTotal=0;
          settings._iRecordsDisplay=0;
        }else{
          //enable pagination
          settings._iRecordsTotal=100000000;
          settings._iRecordsDisplay=1000000000;
        }
      },
      responsive: true,
      language: {
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_",
            "infoEmpty": "No records available",
            "infoFiltered": ""
      },
      ajax: {
        url: "api/user/email_templates",
        type: "GET",
        beforeSend: function(xhr){
          xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
        },
        dataSrc: function(resp){
          return resp;
        },
        data: function ( d ) {
          d.offset=d.start;
          d.limit=d.length;
          d.search = d.search.value;
          d.order = encodeURIComponent((d.order[0].dir == 'asc' ? "-" : "+")+d.columns[d.order[0].column].data);
          delete d.start;
          delete d.length;
          delete d.columns;
          delete d.draw;
          console.log(d);
        }
      },
      columns: [
            { "data": "id",
              "render": function ( data, type, row, meta ) {
                return '<div style="min-width: 60px;"> <span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="EmailTemplate.pre_edit('+data+')"><i class="fa fa-edit"></i></a> </div>';
              }
            },
            { "data": "name" },
            { "data": "subject" },
            { "data": "created_at" }
        ]
    });
  }

  static add(email_template){
    RestClient.post("api/user/email_templates", email_template, function(data){
      toastr.success("Email Template has been created");
      EmailTemplate.get_all();
      $("#add-email-template").trigger("reset");
      $('#add-email-template-modal').modal("hide");
    });
  }

  static update(email_template){
    RestClient.put("api/user/email_templates/"+email_template.id, email_template, function(data){
      toastr.success("Email Template has been updated");
      EmailTemplate.get_all();
      $("#add-email-template").trigger("reset");
      $("#add-email-template *[name='id']").val("");
      $('#add-email-template-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("api/user/email_templates/"+id, function(data){
      AUtils.json2form("#add-email-template", data);
      $("#add-email-template-modal").modal("show");
    });
  }
}
