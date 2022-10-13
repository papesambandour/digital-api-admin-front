class  HttpClient {
    static async http(url,method,data={},headers={}){
        headers=  Object.assign({
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Sec-Fetch-Dest": "document",
            "Sec-Fetch-Mode": "navigate",
            "Sec-Fetch-Site": "same-origin"
        },headers)
        let options  = {
            "credentials": "include",
            "headers": headers,
            "body": JSON.stringify(data),
            "method": method,
            "mode": "cors"
        }
        if(['GET', 'DELETE'].includes(method.toUpperCase())){
            delete options.body ;
        }
       let res =  await fetch(url, options);
       if(res.ok){
           return res.json();
       }else{
          // console.log('await res.json()',await res.json())
           throw new Error((await res.json() )?.message || res.statusText);
       }

    }
    static get(url){
      return HttpClient.http(url, "GET");
    }
    static delete(url){
      return HttpClient.http(url, "DELETE");
    }
    static post(url, body){
      return HttpClient.http(url, "POST", body);
    }
    static put(url, body){
      return HttpClient.http(url, "PUT", body);
    }
}

class Helper{
    static nowDMY(){
        return (new Date()).toISOString().replace('T','').substring(0,10).split('-').reverse().join('-');
    }
   static downloadPDF(content,fileName ) {
        const linkSource = `${content}`;
        const downloadLink = document.createElement("a");

        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        console.log(downloadLink)
        downloadLink.click();
    }
    static select2(id) {
        setTimeout(() => {
            $(`#${id}`).select2();
        },500)

    }
    static activeSelect2(id, formBuilder) {
        if (formBuilder.type == 'select') {
            console.log(`#${id}`)
            $(`#${id}`).select2();
        }
    }
    static activeAllSelect(modelData) {
        setTimeout(() => {
            for (let key in modelData) {
                let builder = modelData[key];
                Helper.activeSelect2(builder.key, builder);
            }
        }, 500)
    }
    static   sanitize(modelData, action,modelMapping) {
        for (let key in modelData) {
            if (action === 'add') {
                if (!(modelMapping[key] && modelMapping[key].add === true)) {
                    delete modelData[key];
                }
            } else if (action === 'edit') {
                if (!(modelMapping[key] && modelMapping[key].edit === true)) {
                    delete modelData[key];
                }
            }

        }

        return modelData;
    }
    static  handleFormatError(data,modelMapping) {
        for(let key in modelMapping){
            if(data[key]){
                modelMapping[key].no_valid = data[key].join('<br>')
            }else {
                if(modelMapping[key]){
                    modelMapping[key].no_valid =false;
                }
            }
        }
    }
    static copy(object) {
        return JSON.parse(JSON.stringify(object));
    }
    static async handleResponseApiSaveUpdate(url,sent,isAdd,modelMapping,code=201){
        try {
            const rest =isAdd
                ? await HttpClient.post(url,sent)
                : await HttpClient.put(url,sent)
            if(rest.code === code) {
                Notiflix
                    .Report
                    .info(
                        "SUCCESS",
                        rest.msg,
                        'FERMER',
                        {
                            svgSize: '42px',
                            messageMaxLength: 10000,
                            plainText: true,
                        },
                    );
                setTimeout(function() {
                    window.location.reload();
                },3000);
            }else{
                Notiflix
                    .Report
                    .info(
                        'Erreur',
                        `Une erreur est survenue`,
                        'FERMER',
                        {
                            svgSize: '42px',
                            messageMaxLength: 100000,
                            plainText: true,
                        },
                    );
                Helper.handleFormatError(rest.data,modelMapping);
            }
        } catch (e) {
            console.log('EERRRRRRRER',e);
        }
    }
    static async handleResponseApiShow(url,code=200){
        try {
            const rest = await HttpClient.get(url);
            if(rest.code === code) {
               return rest.data ;
            }else{
                Notiflix
                    .Report
                    .info(
                        'Erreur',
                        rest.msg,
                        'FERMER',
                        {
                            svgSize: '42px',
                            messageMaxLength: 100000,
                            plainText: true,
                        },
                    );
                return null;
            }
        } catch (e) {
            console.log('EERRRRRRRER',e);
            return  null;
        }
    }
    static async handleResponseApiDelete(url,code=204){
        try {
            const rest = await HttpClient.delete(url);
            if(rest.code === code) {
               return rest.data ;
            }else{
                /*Notiflix
                    .Report
                    .info(
                        'Erreur',
                        rest.msg,
                        'FERMER',
                        {
                            svgSize: '42px',
                            messageMaxLength: 100000,
                            plainText: true,
                        },
                    );*/
                return null;
            }
        } catch (e) {
            console.log('EERRRRRRRER',e);
            return  null;
        }
    }

    static getSelect2(data,name=['name'],separator=' ',id='id') {

       if(typeof name === 'string') {
           name= [name];
       }
        return data.map((dataItem) => {
            return {
                name: Helper.getName(dataItem,name,separator),
                value: dataItem[id],
            }
        })
    }
    static getName(dataItem,name,separator){
        let names = '';
        for (let i=0; i<name.length; i++) {
            names += dataItem[name[i]]  + separator
        }
        return names;
    }
}

class CommissionService{
    static url_commission = '/api/commission';
    static async getCommissionByPartnerAndService(partnersId,sousServiceId){
       let res =  await HttpClient.get(`${CommissionService.url_commission}?where=parteners_id|e|${partnersId},sous_services_id|e|${sousServiceId }`);
       if(res.code ===200){
           return res.data ;
       }else {
           throw new Error("Une erreur est survenue");
       }
    }
    static async addCommission(data){
        return await HttpClient.post(`${CommissionService.url_commission}`, data);
    }
    static async deleteCommission(idCommission){
        try {
            const rest = await HttpClient.delete( `${CommissionService.url_commission}/${idCommission}`);
            if(rest.code === 204) {
                return rest.data ;
            }else{
                return null;
            }
        } catch (e) {
            console.log('EERRRRRRRER',e);
            return  null;
        }
    }
    static isTheLastComm(commission,commissions){
        return commissions[commissions.length - 1].id === commission.id ;
    }
}
class SousServices{
    static url_sous_services = '/api/sous_services';
    static async getSousServices(){
        let res =  await HttpClient.get(`${SousServices.url_sous_services}?where=state|e|ACTIVED`);
        if(res.code ===200){
            return res.data ;
        }else {
            throw new Error("Une erreur est survenue");
        }
    }
}
class SousServicesPartners{
    static url_sous_services_partners = '/api/sous_services_partners';
    static async getSousServicePartners(partnersId){
        let res =  await HttpClient.get(`${SousServicesPartners.url_sous_services_partners}?where=parteners_id|e|${partnersId}`);
        if(res.code ===200){
            return res.data ;
        }else {
            throw new Error("Une erreur est survenue");
        }
    }
    static async add(partners,sousServicePartners){
        let data = {
            partners_id: partners.id,
            sous_services: sousServicePartners
        }
        let res =  await HttpClient.post(`${SousServicesPartners.url_sous_services_partners}`,data);
        return res.code === 201;
    }
}
// $( document).on('.sensible','dblclick',function(elem) {
//     $(elem).css('pointerEvents','all')
//     alert()
// });


    function exportExcel(idButton="",fileName="",url=""){
        if(!$('#date_start').val()){
            return alert('Veuillez choisir une date de debut')
        }

        if(!$('#date_end').val()){
            return alert('Veuillez choisir une date de fin')
        }

        if(!confirm('Attention: Nombre maximum de sortie 50.000 lignes')){
            return ;
        }

        if(!url){
            url = window.location.href;
        }
        if(url.includes('?')){
            url += "&_exported_excel_=1"
        }else {
            url += "?_exported_excel_=1"
        }

        url = url.replace('date_start', '_date_start').replace('date_end', '_date_end');

        url += "&date_start=" + $('#date_start').val()
        url += "&date_end=" + $('#date_end').val();

        document.getElementById(`${idButton}-sniper`).removeAttribute('hidden');
        document.getElementById(`${idButton}`).setAttribute('disabled', 'disabled')
        HttpClient.get(url)
            .then((res)=>{
                if(res.code ===200){
                    let date= Helper.nowDMY()
                    Helper.downloadPDF(res.data,`${fileName+'-'}${date}.xlsx`);
                }else {
                    alert(res.msg);
                }
                document.getElementById(`${idButton}`).removeAttribute('disabled')
                document.getElementById(`${idButton}-sniper`).setAttribute('hidden','hidden');

            }).catch(async (error)=>{
            document.getElementById(`${idButton}`).removeAttribute('disabled')
            document.getElementById(`${idButton}-sniper`).setAttribute('hidden','hidden');
            //console.log(  error);
            alert( error.message);
        })

    }

