<?php
return [
    'Automovel\\V1\\Rest\\Automovel\\Controller' => [
        'collection' => [
            'GET' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel"
       },
       "first": {
           "href": "/automovel?page={page}"
       },
       "prev": {
           "href": "/automovel?page={page}"
       },
       "next": {
           "href": "/automovel?page={page}"
       },
       "last": {
           "href": "/automovel?page={page}"
       }
   }
   "_embedded": {
       "automovel": [
           {
               "_links": {
                   "self": {
                       "href": "/automovel[/:automovel_id]"
                   }
               }
              "nome": "",
              "uf": "",
              "cidade": "",
              "descricao": ""
           }
       ]
   }
}',
            ],
            'POST' => [
                'request' => '{
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel[/:automovel_id]"
       }
   }
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
            ],
            'PUT' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel"
       },
       "first": {
           "href": "/automovel?page={page}"
       },
       "prev": {
           "href": "/automovel?page={page}"
       },
       "next": {
           "href": "/automovel?page={page}"
       },
       "last": {
           "href": "/automovel?page={page}"
       }
   }
   "_embedded": {
       "automovel": [
           {
               "_links": {
                   "self": {
                       "href": "/automovel[/:automovel_id]"
                   }
               }
              "nome": "",
              "uf": "",
              "cidade": "",
              "descricao": ""
           }
       ]
   }
}',
                'request' => '{
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
            ],
        ],
        'entity' => [
            'GET' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel[/:automovel_id]"
       }
   }
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
            ],
            'PUT' => [
                'request' => '{
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel[/:automovel_id]"
       }
   }
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
            ],
            'DELETE' => [
                'request' => '{
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/automovel[/:automovel_id]"
       }
   }
   "nome": "",
   "uf": "",
   "cidade": "",
   "descricao": ""
}',
            ],
        ],
    ],
];
