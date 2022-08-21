const app = new Vue({
    el: '#app',
    data: {
        url: '/api/sous_services',
        page: 1,
        isAdd: true,
        showModal: false,
        title: "CONFIGURATION",
        typeServices: {},
        sousServices: [],
        services: {},
        sousService: {},
        sousServiceMapping: {},
        commissions: [
            {
                amount_start: 0,
                amount_end: 0,
                amount_commssion: 0,
                taux_commission: 0,
                taux_fee: 0,
                amount_fee: 0,
                parteners_id: 0,
                sous_services_id: 0,
            }
        ],
        partners: {},
        commission: {
            amount_start: 0,
            amount_end: 0,
            amount_commssion: 0,
            taux_commission: 0,
            taux_fee: 0,
            amount_fee: 0,
            parteners_id: 0,
            sous_services_id: 0,
        }

    },
    methods: {
        configCommissionModal(idService) {
            $('#modalFraisSouService').modal('show');
            this.sousService = this.getSousService(idService);
            this.commissions = this.sousService.commissions?.filter((commission) => {
                return commission.parteners_id = this.partners.id
            });
            this.commission.parteners_id = this.partners.id;
            this.commission.sous_services_id = this.sousService.id;
            console.log(this.commissions);
        },
        showDetails(idService) {
            this.sousService = this.getSousService(idService);
            this.normalize();
            this.sousServiceMapping = this.mapping(this.sousService);
            console.log(this.sousService.regex_message_validation)
            $('#modalDetails').modal('show');
        },
        normalize() {
            this.sousService.when_status_for_callback = this.sousService?.when_status_for_callback?.split('|');
            this.sousService.when_pre_status_for_callback = this.sousService?.when_pre_status_for_callback?.split('|');
        },
        unNormalize(sousService) {
            sousService.when_status_for_callback = sousService?.when_status_for_callback?.join('|');
            sousService.when_pre_status_for_callback = sousService?.when_pre_status_for_callback?.join('|');
        },
        showModalUpdateService(idService) {
            this.isAdd = false;
            this.sousService = this.getSousService(idService);
            this.normalize();
            this.sousServiceMapping = this.mapping(this.sousService);

            $('#modalEditAdd').modal('show');
            console.log(this.sousService);
            Helper.activeAllSelect(this.sousServiceMapping);
        },
        showModalAddService() {
            this.isAdd = true;
            this.sousService = {};
            this.sousServiceMapping = this.mapping(this.sousService);
            $('#modalEditAdd').modal('show');
            console.log(this.sousService);
            Helper.activeAllSelect(this.sousServiceMapping);
        },
        async submit(action) {
            let sent = Helper.copy(this.sousService);
            let id = this.sousService.id;
            let url = this.isAdd ? this.url : `${this.url}/${id}`
            this.unNormalize(sent);
            sent = Helper.sanitize(sent, this.isAdd ? 'add' : 'edit', this.sousServiceMapping)
            console.log(sent);
            await Helper.handleResponseApiSaveUpdate(url, sent, this.isAdd, this.sousServiceMapping)
        },
        mapping(sousService) {
            sousService.when_status_for_callback = sousService?.when_status_for_callback || []
            sousService.when_pre_status_for_callback = sousService.when_pre_status_for_callback || []
            return {
                'id': {
                    key: 'id',
                    name: '#ID',
                    value: sousService?.id,
                    type: 'hidden',
                    input: 'hidden',
                    edit: false,
                    add: false,
                    items: []
                },
                'name': {
                    key: 'name',
                    name: 'Libelle',
                    value: sousService?.name,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: [],
                    no_valid: false,
                },
                'code': {
                    key: 'code',
                    name: 'Code',
                    value: sousService?.code,
                    type: 'text',
                    input: 'text',
                    edit: false,
                    add: true,
                    items: []
                },
                'services_id': {
                    key: 'services_id',
                    name: 'Service',
                    value: sousService?.service?.name,
                    val: sousService?.services_id,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: Helper.getSelect2(this.services),
                },
                'type_services_id': {
                    key: 'type_services_id',
                    name: 'Type Service',
                    value: sousService?.typeService?.name,
                    val: sousService?.type_services_id,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: Helper.getSelect2(this.typeServices)
                },
                'regex_phone': {
                    key: 'regex_phone',
                    name: 'Validation Phone',
                    value: sousService?.regex_phone,
                    val: sousService.regex_phone,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'ussd_code': {
                    key: 'ussd_code',
                    name: 'Ussd code',
                    value: sousService?.ussd_code,
                    val: sousService?.ussd_code,
                    type: 'hidden',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'regex_message_validation': {
                    key: 'regex_message_validation',
                    name: 'Message de validation',
                    value: sousService?.regex_message_validation,
                    val: sousService?.regex_message_validation,
                    type: 'textarea',
                    input: 'textarea',
                    edit: true,
                    add: true,
                    items: []
                },
                'message_retour_ussd': {
                    key: 'message_retour_ussd',
                    name: 'Message retour ussd',
                    value: sousService?.message_retour_ussd,
                    val: sousService?.message_retour_ussd,
                    type: 'textarea',
                    input: 'textarea',
                    edit: true,
                    add: true,
                    items: []
                },
                'position_validation_index': {
                    key: 'position_validation_index',
                    name: 'Position des paramètres',
                    value: `<pre>${sousService?.position_validation_index || ''} </pre>`,
                    val: sousService?.position_validation_index,
                    type: 'textarea',
                    input: 'textarea',
                    edit: true,
                    add: true,
                    items: []
                },
                'valid_ength': {
                    key: 'valid_ength',
                    name: 'Longeur des paramètres',
                    value: sousService?.valid_ength,
                    val: sousService?.valid_ength,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'need_phone': {
                    key: 'need_phone',
                    name: 'Provider de type',
                    value: sousService?.need_phone === 1 ? "TELEPHONE USSD" : "API",
                    val: sousService?.need_phone,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [{
                        name: 'TELEPHONE USSD',
                        value: 1,
                    }, {
                        name: 'API',
                        value: 0,
                    },]
                },
                'icon': {
                    key: 'icon',
                    name: 'Logo',
                    value: `<img class="logo-service" src="${sousService?.icon}" alt="Logo" />`,
                    val: sousService?.icon,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'state': {
                    key: 'state',
                    name: 'Status',
                    value: sousService?.state,
                    val: sousService?.state,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    //'ACTIVED','INACTIVED','DELETED'
                    items: [{
                        name: 'ACTIVED',
                        value: 'ACTIVED',
                    }, {
                        name: 'INACTIVED',
                        value: 'INACTIVED',
                    },
                        {
                            name: 'DELETED',
                            value: 'DELETED',
                        },
                    ]
                },
                'api_manager_class_name': {
                    key: 'api_manager_class_name',
                    name: 'Api manager class name',
                    value: sousService?.api_manager_class_name,
                    val: sousService?.api_manager_class_name,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'api_manager_namespace': {
                    key: 'api_manager_namespace',
                    name: 'api manager namespace',
                    value: sousService?.api_manager_namespace,
                    val: sousService?.api_manager_namespace,
                    type: 'text',
                    input: 'text',
                    edit: true,
                    add: true,
                    items: []
                },
                'amount_commssion': {
                    key: 'amount_commssion',
                    name: 'Montant commission',
                    value: sousService?.amount_commssion,
                    val: sousService?.amount_commssion,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'taux_commission': {
                    key: 'taux_commission',
                    name: 'Taux commission',
                    value: sousService?.taux_commission,
                    val: sousService?.taux_commission,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'amount_fee': {
                    key: 'amount_fee',
                    name: 'Montant fraix',
                    value: sousService?.amount_fee,
                    val: sousService?.amount_fee,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'taux_fee': {
                    key: 'taux_fee',
                    name: 'Taux frais',
                    value: sousService?.taux_fee,
                    val: sousService?.taux_fee,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'pending_timeout': {
                    key: 'pending_timeout',
                    name: 'Timeout en minute(s). (-1 si pas de timeout)',
                    value: +sousService?.pending_timeout === -1 ? 'Pas de timeout' : `${sousService?.pending_timeout} minute(s)`,
                    val: sousService?.pending_timeout || -1,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'pre_status_error_type': {
                    key: 'pre_status_error_type',
                    name: 'Pres Status apres échec',
                    value: sousService?.pre_status_error_type,
                    val: sousService?.pre_status_error_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_ERROR',
                            value: 'PENDING_ON_ERROR',
                        },
                        {
                            name: 'FAILED_ON_ERROR',
                            value: 'FAILED_ON_ERROR',
                        },
                        {
                            name: 'SUCCESS_ON_ERROR',
                            value: 'SUCCESS_ON_ERROR',
                        },
                        {
                            name: 'PROCESSING_ON_ERROR',
                            value: 'PROCESSING_ON_ERROR',
                        },
                    ]
                },
                'status_error_type': {
                    key: 'status_error_type',
                    name: 'Status apres échec',
                    value: sousService?.status_error_type,
                    val: sousService?.status_error_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_ERROR',
                            value: 'PENDING_ON_ERROR',
                        },
                        {
                            name: 'FAILED_ON_ERROR',
                            value: 'FAILED_ON_ERROR',
                        },
                        {
                            name: 'SUCCESS_ON_ERROR',
                            value: 'SUCCESS_ON_ERROR',
                        },
                        {
                            name: 'PROCESSING_ON_ERROR',
                            value: 'PROCESSING_ON_ERROR',
                        },
                    ]
                },
                'pre_status_success_type': {
                    key: 'pre_status_success_type',
                    name: 'Pres Status apres succès',
                    value: sousService?.pre_status_success_type,
                    val: sousService?.pre_status_success_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_SUCCESS',
                            value: 'PENDING_ON_SUCCESS',
                        },
                        {
                            name: 'SUCCESS_ON_SUCCESS',
                            value: 'SUCCESS_ON_SUCCESS',
                        },
                        {
                            name: 'PROCESSING_ON_SUCCESS',
                            value: 'PROCESSING_ON_SUCCESS',
                        },
                    ]
                },
                'status_success_type': {
                    key: 'status_success_type',
                    name: 'Status apres succès',
                    value: sousService?.status_success_type,
                    val: sousService?.status_success_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_SUCCESS',
                            value: 'PENDING_ON_SUCCESS',
                        },
                        {
                            name: 'SUCCESS_ON_SUCCESS',
                            value: 'SUCCESS_ON_SUCCESS',
                        },
                        {
                            name: 'PROCESSING_ON_SUCCESS',
                            value: 'PROCESSING_ON_SUCCESS',
                        },
                    ]
                },
                'pre_status_timeout_type': {
                    key: 'pre_status_timeout_type',
                    name: 'Pres Status apres timeout',
                    value: sousService?.pre_status_timeout_type,
                    val: sousService?.pre_status_timeout_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_TIMEOUT',
                            value: 'PENDING_ON_TIMEOUT',
                        },
                        {
                            name: 'SUCCESS_ON_TIMEOUT',
                            value: 'SUCCESS_ON_TIMEOUT',
                        },
                        {
                            name: 'PROCESSING_ON_TIMEOUT',
                            value: 'PROCESSING_ON_TIMEOUT',
                        },
                        {
                            name: 'FAILED_ON_TIMEOUT',
                            value: 'FAILED_ON_TIMEOUT',
                        },
                    ]
                },
                'status_timeout_type': {
                    key: 'status_timeout_type',
                    name: 'Status apres timeout',
                    value: sousService?.status_timeout_type,
                    val: sousService?.status_timeout_type,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'PENDING_ON_TIMEOUT',
                            value: 'PENDING_ON_TIMEOUT',
                        },
                        {
                            name: 'SUCCESS_ON_TIMEOUT',
                            value: 'SUCCESS_ON_TIMEOUT',
                        },
                        {
                            name: 'PROCESSING_ON_TIMEOUT',
                            value: 'PROCESSING_ON_TIMEOUT',
                        },
                        {
                            name: 'FAILED_ON_TIMEOUT',
                            value: 'FAILED_ON_TIMEOUT',
                        },
                    ]
                },
                'when_pre_status_for_callback': {
                    key: 'when_pre_status_for_callback',
                    name: 'Valeur du pres status pour envoyer le callback',
                    value: sousService?.when_pre_status_for_callback,
                    val: sousService?.when_pre_status_for_callback,
                    type: 'select',
                    input: 'select',
                    multiple: true,
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'SUCCESS',
                            value: 'SUCCESS',
                        },
                        {
                            name: 'PENDING',
                            value: 'PENDING',
                        },
                        {
                            name: 'PROCESSING',
                            value: 'PROCESSING',
                        },
                        {
                            name: 'FAILLED',
                            value: 'FAILLED',
                        },
                        {
                            name: 'CANCELED',
                            value: 'CANCELED',
                        },
                    ]
                },
                'when_status_for_callback': {
                    key: 'when_status_for_callback',
                    name: 'Valeur du  status pour envoyer le callback',
                    value: sousService?.when_status_for_callback,
                    val: sousService?.when_status_for_callback,
                    type: 'select',
                    input: 'select',
                    multiple: true,
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'SUCCESS',
                            value: 'SUCCESS',
                        },
                        {
                            name: 'PENDING',
                            value: 'PENDING',
                        },
                        {
                            name: 'PROCESSING',
                            value: 'PROCESSING',
                        },
                        {
                            name: 'FAILLED',
                            value: 'FAILLED',
                        },
                        {
                            name: 'CANCELED',
                            value: 'CANCELED',
                        },
                    ]
                },
                'max_limit_transaction': {
                    key: 'max_limit_transaction',
                    name: 'Montant max par transaction (-1 si pas de limite)',
                    value: sousService?.max_limit_transaction === -1 ? 'Pas de limitation' : sousService?.max_limit_transaction + ' XOF',
                    val: sousService?.max_limit_transaction || -1,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'min_limit_transaction': {
                    key: 'min_limit_transaction',
                    name: 'Montant min par transaction (-1 si pas de limite)',
                    value: sousService?.min_limit_transaction === -1 ? 'Pas de limitation' : sousService?.min_limit_transaction + ' XOF',
                    val: sousService?.min_limit_transaction,
                    type: 'text',
                    input: 'number',
                    edit: true,
                    add: true,
                    items: []
                },
                'type_operation': {
                    key: 'type_operation',
                    name: 'Type operation',
                    value: sousService?.type_operation,
                    val: sousService?.type_operation,
                    type: 'select',
                    input: 'select',
                    edit: true,
                    add: true,
                    items: [
                        {
                            name: 'DEBIT',
                            value: 'DEBIT',
                        },
                        {
                            name: 'CREDIT',
                            value: 'CREDIT',
                        }
                    ]
                },

                'created_at': {
                    key: 'created_at',
                    name: 'Date de creation',
                    value: sousService?.created_at?.toString()?.replace('T', ' ')?.substring(0, 19),
                    val: sousService?.created_at,
                    type: 'hidden',
                    edit: false,
                    add: false,
                    items: []
                },
            }
        },
        getSousService(idService) {
            const sousService = this.sousServices.find((sousService) => +sousService.id === +idService);
            return JSON.parse(JSON.stringify(sousService));
        },
        getServicesSelect() {
            return this.services.map((service) => {
                return {
                    name: service.name,
                    value: service.id,
                }
            })
        },
        addCommission() {
            console.log('Commission', this.commission);
            this.commissions.push(Helper.copy(this.commission));
            this.commission = {
                amount_start: 0,
                amount_end: 0,
                amount_commssion: 0,
                taux_commission: 0,
                taux_fee: 0,
                amount_fee: 0,
                parteners_id: 0,
                sous_services_id: 0,
            };
        },
        deleteCommission(deleteCommission) {
            if (confirm('Vous-vous supprimer le frais')) {
                console.log(deleteCommission);
                this.commissions = this.commissions.filter((commission) => {
                    return commission.id !== deleteCommission.id
                })
            }
            /*   Notiflix
                   .Confirm
                   .show('Ajout clé API ','Vous-vous supprimer le frais',
                       'Oui',
                       'Non',
                       () => {
                           console.log(deleteCommission);
                           this.commissions = this.commissions.filter((commission)=>{
                               return commission.id !== deleteCommission.id
                           })

                       },
                       () => {console.log('If you say so...');},
                       { messageMaxLength: 90000,},);*/
        },
        getMinStart(){
            if(this.commissions.length){
                return +this.commissions[this.commissions.length - 1].amount_end + 1;
            }
            return 0;
        },
        getMaxStart(){
           let max=   +this.commission.amount_end  -1 ;
           if(max < 1){
               return 0 ;
           }
           return max;
        },
        getMinEnd(){
            if(+this.commission.amount_end === -1){
                return  -1;
            }
          return +this.commission.amount_start + 1
        },
        isLast(){
            if(this.commissions.length){
                return +this.commissions[this.commissions.length - 1].amount_end  ===-1;
            }
        }
    },
    computed: {},
    async created() {
        this.sousServices = JSON.parse($("#_data_sous_services").val());
        this.services = JSON.parse($("#_data_services").val()) || {};
        this.typeServices = JSON.parse($("#_data_type_services").val()) || {};
        this.partners = JSON.parse($("#_data_partner").val()) || {};
        this.sousService = {};
    },
});

Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', {bubbles: true, cancelable: true});
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});
