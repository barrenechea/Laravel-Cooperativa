<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Partner;
use App\Location;

class InitPartner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:partners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes partners and their respective locations';

    private $defaultMail = 'secretaria@alamedamaipu.cl';
    private $remainingToCooperativa = true;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->cleanup();

        $socios = [];

        $socios[] = [
            'run' => '5905993-9',
            'nombre' => 'Adriana del Carmen Campos Águila',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.72'],
                ['AS', 'L.189'],
                ['AM', 'L.25'],
            ],
        ];

        $socios[] = [
            'run' => '13894478-6',
            'nombre' => 'Alejandra Rossana Martinez Stumpf',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.42'],
                ['AS', 'L.162'],
                ['AM', 'L.43'],
            ],
        ];

        $socios[] = [
            'run' => '9407686-2',
            'nombre' => 'Alejandro Esteban Mora Rodríguez',
            'email' => 'a_mora16@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.118'],
            ],
        ];

        $socios[] = [
            'run' => '7811625-0',
            'nombre' => 'Alejandro Tello Sánchez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.13'],
                ['AS', 'L.184'],
                ['AM', 'L.19'],
            ],
        ];

        $socios[] = [
            'run' => '7052086-9',
            'nombre' => 'Álvaro Eladio Hernández Espinace',
            'email' => 'ahernace@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.39'],
                ['AS', 'L.129'],
                ['AM', 'L.22'],
            ],
        ];

        $socios[] = [
            'run' => '16425018-0',
            'nombre' => 'Angelo Carreño Stumpf',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.18'],
                ['AS', 'L.23'],
            ],
        ];

        $socios[] = [
            'run' => '10116227-3',
            'nombre' => 'Amelia Guzmán Aravena',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.153'],
            ],
        ];

        $socios[] = [
            'run' => '6007498-4',
            'nombre' => 'Ana Díaz Ceballos',
            'email' => 'anadiaz1313@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.63'],
                ['AS', 'L.150'],
                ['AM', 'L.18'],
            ],
        ];

        $socios[] = [
            'run' => '9578702-9',
            'nombre' => 'Angélica González Garcés',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.69'],
                ['AS', 'L.128'],
                ['AM', 'L.36'],
            ],
        ];

        $socios[] = [
            'run' => '16118497-7',
            'nombre' => 'Ariel Badilla Rodríguez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.44'],
            ],
        ];

        $socios[] = [
            'run' => '17727732-6',
            'nombre' => 'Basilia Lizana Cruz',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.198'],
            ],
        ];

        $socios[] = [
            'run' => '22122772-7',
            'nombre' => 'Belker Alania Villanueva',
            'email' => 'jeanbelker11@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.55'],
                ['AS', 'L.115'],
            ],
        ];

        $socios[] = [
            'run' => '9359126-7',
            'nombre' => 'Bernarda Pérez Madrid',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.30'],
                ['AS', 'L.64'],
                ['AS', 'L.106'],
                ['AM', 'L.52'],
            ],
        ];

        $socios[] = [
            'run' => '13376664-2',
            'nombre' => 'Blanca Maldonado Henríquez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.82'],
                ['AS', 'L.130'],
                ['AM', 'L.13'],
            ],
        ];

        $socios[] = [
            'run' => '22398145-3',
            'nombre' => 'Carla Ampuero Calani',
            'email' => 'karla.ampu@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.35'],
                ['AS', 'L.36'],
                ['AS', 'L.68'],
                ['AS', 'L.71'],
                ['AS', 'L.177'],
                ['AM', 'L.14'],
            ],
        ];

        $socios[] = [
            'run' => '11851699-0',
            'nombre' => 'Carlina Alarcón Castro',
            'email' => 'carlaalarcon23@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.41'],
                ['AS', 'L.54'],
                ['AS', 'L.167'],
                ['AM', 'L.75'],
                ['AM', 'L.76'],
            ],
        ];

        $socios[] = [
            'run' => '8165195-7',
            'nombre' => 'Carlos Cid Marconi',
            'email' => 'ccidmarconi@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.75'],
                ['AS', 'L.163'],
                ['AM', 'L.57'],
            ],
        ];

        $socios[] = [
            'run' => '7630962-0',
            'nombre' => 'Carlos Alberto Mendoza Aravena',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.195'],
            ],
        ];

        $socios[] = [
            'run' => '14643478-9',
            'nombre' => 'Chin-Lang Lin',
            'email' => 'ash_groudon_0306@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.86'],
                ['AS', 'L.160'],
                ['AM', 'L.55'],
            ],
        ];

        $socios[] = [
            'run' => '15421272-8',
            'nombre' => 'Claudio Ávila Guzmán',
            'email' => 'claudiorsk@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.191'],
            ],
        ];

        $socios[] = [
            'run' => '76589610-K',
            'nombre' => 'Com. Montero e Hijos Ltda.',
            'email' => 'miguel@monterosport.cl',
            'ubicaciones' => [
                ['AS', 'L.20'],
                ['AS', 'L.123'],
                ['AS', 'L.170'],
            ],
        ];

        $socios[] = [
            'run' => '8453675-K',
            'nombre' => 'Comunidad Hereditaria - Jorge Vila Vargas',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.84'],
                ['AS', 'L.172'],
                ['AM', 'L.1'],
            ],
        ];

        $socios[] = [
            'run' => '7410037-6',
            'nombre' => 'Comunidad Hereditaria - Teresa Jofré Hernández',
            'email' => 'tjofreh@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.10'],
                ['AS', 'L.169'],
                ['AM', 'L.15'],
            ],
        ];

        $socios[] = [
            'run' => '16942789-5',
            'nombre' => 'Dea Ho Kim',
            'email' => 'comercial.vip@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.19'],
                ['AS', 'L.51'],
                ['AS', 'L.109'],
                ['AS', 'L.114'],
            ],
        ];

        $socios[] = [
            'run' => '19670629-1',
            'nombre' => 'Darinka Esther Orellana Acuña',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'L.83'],
            ],
        ];

        $socios[] = [
            'run' => '22107444-0',
            'nombre' => 'Edgar Ticona Chura',
            'email' => 'eticona_1348@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.181'],
            ],
        ];

        $socios[] = [
            'run' => '14683374-8',
            'nombre' => 'Edgardo Cáceres Carhuayano',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.194'],
            ],
        ];

        $socios[] = [
            'run' => '10760808-7',
            'nombre' => 'Elías Gómez Oyarce',
            'email' => 'atacamanorteltda@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.91'],
                ['AS', 'L.140'],
                ['AM', 'L.74'],
            ],
        ];

        $socios[] = [
            'run' => '15786765-2',
            'nombre' => 'Erik Orellana Acuña',
            'email' => 'erik.orellana.1984@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.80'],
                ['AM', 'L.68'],
            ],
        ];

        $socios[] = [
            'run' => '22540092-K',
            'nombre' => 'Erik Alania Villanueva',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.105'],
                ['AM', 'L.78'],
            ],
        ];

        $socios[] = [
            'run' => '9094738-9',
            'nombre' => 'Erika González Iturra',
            'email' => 'erika.gonzalez@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.9'],
                ['AS', 'L.40'],
                ['AS', 'L.161'],
                ['AM', 'L.63'],
                ['AM', 'L.79'],
            ],
        ];

        $socios[] = [
            'run' => '21861951-7',
            'nombre' => 'Ernesto Flores Lima',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.70'],
                ['AS', 'L.203'],
            ],
        ];

        $socios[] = [
            'run' => '9690603-K',
            'nombre' => 'Eufrosina Fuentes Agurto',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.24'],
                ['AS', 'L.107'],
                ['AS', 'L.183'],
                ['AM', 'L.29'],
            ],
        ];

        $socios[] = [
            'run' => '7098704-K',
            'nombre' => 'Filomena Cerda Reyes',
            'email' => 'xime.cerdareyes@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.48'],
                ['AS', 'L.197'],
                ['AM', 'L.60'],
            ],
        ];

        $socios[] = [
            'run' => '7772083-9',
            'nombre' => 'Genoveva Acuña Pérez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.45'],
                ['AS', 'L.164'],
            ],
        ];

        $socios[] = [
            'run' => '15670445-8',
            'nombre' => 'Giannina Bahamontes Tapia',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.17'],
            ],
        ];

        $socios[] = [
            'run' => '18741090-8',
            'nombre' => 'Giovanni Carreño Stumpf',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.38'],
                ['AS', 'L.67'],
            ],
        ];

        $socios[] = [
            'run' => '8458290-5',
            'nombre' => 'Gloria Polanco Ávila',
            'email' => 'gloriapolancoa@hotmail.com',
            'ubicaciones' => [
                ['AM', 'L.11'],
            ],
        ];

        $socios[] = [
            'run' => '9494164-4',
            'nombre' => 'Gladys Paredes Marti',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'L.BA5'],
            ],
        ];

        $socios[] = [
            'run' => '9119176-8',
            'nombre' => 'Guadalupe Vidal Arratia',
            'email' => 'gvidalarratia@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.56'],
                ['AS', 'L.179'],
                ['AM', 'L.16'],
            ],
        ];

        $socios[] = [
            'run' => '8893861-5',
            'nombre' => 'Héctor Granado Flores',
            'email' => 'nba_964@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.25'],
            ],
        ];

        $socios[] = [
            'run' => '14361738-6',
            'nombre' => 'Hernán Espinoza Quiroga',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.100'],
                ['AS', 'L.102'],
                ['AM', 'L.6'],
            ],
        ];

        $socios[] = [
            'run' => '8448421-0',
            'nombre' => 'Higinio Álvarez Espinoza',
            'email' => 'halvarez0917@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.89'],
                ['AS', 'L.139'],
                ['AM', 'L.56'],
            ],
        ];

        $socios[] = [
            'run' => '14755044-8',
            'nombre' => 'Hsiu Tuan Hsu',
            'email' => 'ventas@casatex.cl',
            'ubicaciones' => [
                ['AS', 'L.32'],
                ['AS', 'L.43'],
                ['AS', 'L.154'],
                ['AS', 'L.157'],
            ],
        ];

        $socios[] = [
            'run' => '5120436-0',
            'nombre' => 'Irma Godoy Carrera',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.15'],
                ['AS', 'L.76'],
                ['AS', 'L.108'],
                ['AS', 'L.202'],
                ['AM', 'L.34'],
                ['AM', 'L.35'],
            ],
        ];

        $socios[] = [
            'run' => '14689894-7',
            'nombre' => 'Irma Paredes de Guarachi',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.94'],
            ],
        ];

        $socios[] = [
            'run' => '22215756-0',
            'nombre' => 'Ismael Huarachi Yampara',
            'email' => 'iuhy@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.134'],
            ],
        ];

        $socios[] = [
            'run' => '77473360-4',
            'nombre' => 'Inmobiliaria Jaime Salinas Ortiz EIRL',
            'email' => 'jjassosalina81@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.159'],
                ['AS', 'L.174'],
            ],
        ];

        $socios[] = [
            'run' => '8535372-1',
            'nombre' => 'Javier Medina Villagrán',
            'email' => 'yesterday@vtr.net',
            'ubicaciones' => [
                ['AS', 'L.53'],
                ['AM', 'L.51'],
            ],
        ];

        $socios[] = [
            'run' => '6574878-9',
            'nombre' => 'Javier Pineda Sanhueza',
            'email' => 'christian.pineda.m@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.34'],
                ['AS', 'L.37'],
                ['AS', 'L.50'],
                ['AS', 'L.93'],
                ['AS', 'L.133'],
                ['AS', 'L.186'],
                ['AS', 'L.187'],
                ['AM', 'L.38'],
                ['AM', 'L.61'],
                ['AM', 'M.E'],
            ],
        ];

        $socios[] = [
            'run' => '13041699-3',
            'nombre' => 'Johanna Iradi Tobar',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.3'],
                ['AS', 'L.136'],
                ['AM', 'L.72'],
            ],
        ];

        $socios[] = [
            'run' => '15506120-0',
            'nombre' => 'Johanna Morales Cornejo',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.85'],
                ['AS', 'L.176'],
                ['AM', 'L.58'],
            ],
        ];

        $socios[] = [
            'run' => '14189978-3',
            'nombre' => 'Joice Ordenez Díaz',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.144'],
            ],
        ];

        $socios[] = [
            'run' => '21468370-9',
            'nombre' => 'José Maldonado Medina',
            'email' => 'confeccionesfernanda45@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.121'],
            ],
        ];

        $socios[] = [
            'run' => '10588964-K',
            'nombre' => 'Juan Briones Fuentes',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.62'],
                ['AS', 'L.124'],
                ['AM', 'L.17'],
            ],
        ];

        $socios[] = [
            'run' => '5898151-6',
            'nombre' => 'Julio Erazo Gaete',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.90'],
                ['AS', 'L.132'],
                ['AM', 'L.45'],
            ],
        ];

        $socios[] = [
            'run' => '6440881-K',
            'nombre' => 'Julio Lara Gonzalez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.26'],
                ['AS', 'L.182'],
                ['AM', 'L.5'],
            ],
        ];

        $socios[] = [
            'run' => '15482047-7',
            'nombre' => 'Karen Palma Villegas',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.22'],
            ],
        ];

        $socios[] = [
            'run' => '14469034-6',
            'nombre' => 'Kuo-Chen Wu',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'M.C'],
            ],
        ];

        $socios[] = [
            'run' => '77073320-0',
            'nombre' => 'Lencerías Darinka Ltda.',
            'email' => 'lenceriasdarinkadk@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.4'],
                ['AS', 'L.147'],
                ['AM', 'L.66'],
            ],
        ];

        $socios[] = [
            'run' => '8825888-6',
            'nombre' => 'Leonor Rojas Ortega',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.28'],
                ['AS', 'L.149'],
                ['AM', 'L.21'],
            ],
        ];

        $socios[] = [
            'run' => '19496399-8',
            'nombre' => 'Lia Magdalena Gómez Lizama',
            'email' => 'lia.magdalena.3@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.12'],
            ],
        ];

        $socios[] = [
            'run' => '12607766-1',
            'nombre' => 'Lorena del Carmen Lizama Cortez',
            'email' => 'lorena-lc23@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.148'],
            ],
        ];

        $socios[] = [
            'run' => '17371945-0',
            'nombre' => 'Luis Eduardo Acevedo Araya',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.135'],
            ],
        ];

        $socios[] = [
            'run' => '11474258-9',
            'nombre' => 'Luis Pavez Álvarez',
            'email' => 'traffictour@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.193'],
            ],
        ];

        $socios[] = [
            'run' => '9190874-3',
            'nombre' => 'Luz María Ayala Bruna',
            'email' => 'lumiayala@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.52'],
                ['AS', 'L.173'],
                ['AM', 'L.47'],
            ],
        ];

        $socios[] = [
            'run' => '13546343-4',
            'nombre' => 'Manuel Gatica Salgado',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.61'],
                ['AS', 'L.166'],
                ['AM', 'L.37'],
            ],
        ];

        $socios[] = [
            'run' => '10084921-6',
            'nombre' => 'Margarita Stumpf Jerez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.112'],
                ['AS', 'L.113'],
                ['AS', 'L.122'],
                ['AS', 'L.158'],
                ['AS', 'L.175'],
                ['AM', 'L.3'],
                ['AM', 'L.4'],
                ['AM', 'L.42'],
                ['AM', 'L.49'],
            ],
        ];

        $socios[] = [
            'run' => '9607416-6',
            'nombre' => 'María Cecilia Huerta León',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'L.73'],
            ],
        ];

        $socios[] = [
            'run' => '22258495-7',
            'nombre' => 'María Daviu de Maribal',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.95'],
            ],
        ];

        $socios[] = [
            'run' => '9105619-4',
            'nombre' => 'María Fredes Escobar',
            'email' => 'rodrigo.alejandro.93@gmail.com',
            'ubicaciones' => [
                ['AM', 'L.10'],
            ],
        ];

        $socios[] = [
            'run' => '10968043-5',
            'nombre' => 'María Ivette Badilla Badilla',
            'email' => 'mari.badillab@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.73'],
                ['AS', 'L.98'],
                ['AS', 'L.116'],
                ['AS', 'L.119'],
                ['AS', 'L.138'],
                ['AS', 'L.145'],
                ['AM', 'L.9'],
                ['AM', 'L.32'],
                ['AM', 'L.82'],
            ],
        ];

        $socios[] = [
            'run' => '14719183-9',
            'nombre' => 'María Luisa Olaya Conde',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.77'],
            ],
        ];

        $socios[] = [
            'run' => '5905389-2',
            'nombre' => 'María Medina Belmar',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.81'],
                ['AS', 'L.111'],
                ['AM', 'L.62'],
            ],
        ];

        $socios[] = [
            'run' => '12164601-3',
            'nombre' => 'María Molina Maturana',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.8'],
                ['AS', 'L.185'],
                ['AM', 'L.39'],
            ],
        ];

        $socios[] = [
            'run' => '4995108-6',
            'nombre' => 'María Rosa León Toro',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.103'],
                ['AM', 'L.59'],
            ],
        ];

        $socios[] = [
            'run' => '10476038-4',
            'nombre' => 'Mario Contreras Salgado',
            'email' => 'mariocontreras_38@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.6'],
                ['AS', 'L.178'],
                ['AM', 'L.81'],
            ],
        ];

        $socios[] = [
            'run' => '5636520-6',
            'nombre' => 'Marta Montecinos Lara',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.16'],
                ['AS', 'L.110'],
                ['AM', 'L.23'],
            ],
        ];

        $socios[] = [
            'run' => '13483469-2',
            'nombre' => 'Mirian de la Vega Rivera',
            'email' => 'wladimiraviles@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.57'],
                ['AS', 'L.143'],
                ['AM', 'L.31'],
            ],
        ];

        $socios[] = [
            'run' => '12471556-3',
            'nombre' => 'Mónica Barrera Pizarro',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.2'],
                ['AM', 'L.2'],
            ],
        ];

        $socios[] = [
            'run' => '6977218-8',
            'nombre' => 'Mónica Faray Jordan',
            'email' => 'monicafaray@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.1'],
                ['AS', 'L.155'],
                ['AM', 'L.77'],
            ],
        ];

        $socios[] = [
            'run' => '17837818-K',
            'nombre' => 'Natalia Guiñez Badilla',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.125'],
            ],
        ];

        $socios[] = [
            'run' => '8431765-9',
            'nombre' => 'Natividad Flores Alcaide',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.137'],
            ],
        ];

        $socios[] = [
            'run' => '19281236-4',
            'nombre' => 'Nicole Soto Araya',
            'email' => 'nic.sotoa@alumnos.duoc.cl',
            'ubicaciones' => [
                ['AM', 'L.65'],
            ],
        ];

        $socios[] = [
            'run' => '21880574-4',
            'nombre' => 'Olga Cuno Roque',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.127'],
            ],
        ];

        $socios[] = [
            'run' => '9594638-0',
            'nombre' => 'Olga Salazar Pino',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.101'],
                ['AS', 'L.142'],
                ['AM', 'L.24'],
            ],
        ];

        $socios[] = [
            'run' => '7746694-0',
            'nombre' => 'Osvaldo Guiñez Gonzalez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.92'],
                ['AS', 'L.99'],
                ['AM', 'L.53'],
                ['AM', 'L.54'],
            ],
        ];

        $socios[] = [
            'run' => '12458998-3',
            'nombre' => 'Patricia Paredes Martí',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.49'],
                ['AS', 'L.126'],
                ['AM', 'L.64'],
                ['AM', 'L.BA6'],
            ],
        ];

        $socios[] = [
            'run' => '15665684-4',
            'nombre' => 'Paulina Martínez Stumpf',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.97'],
                ['AM', 'L.44'],
            ],
        ];

        $socios[] = [
            'run' => '10870415-2',
            'nombre' => 'Ramón Belaunde Belaunde',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.27'],
                ['AS', 'L.171'],
                ['AS', 'L.190'],
                ['AM', 'L.26'],
                ['AM', 'L.27'],
            ],
        ];

        $socios[] = [
            'run' => '15404373-K',
            'nombre' => 'Raúl Badilla Rodríguez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.46'],
            ],
        ];

        $socios[] = [
            'run' => '7315247-K',
            'nombre' => 'Raúl Castillo Ormeño',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.60'],
                ['AM', 'L.7'],
            ],
        ];

        $socios[] = [
            'run' => '6340679-1',
            'nombre' => 'Raúl Celis Peñaloza',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.88'],
                ['AS', 'L.168'],
                ['AM', 'L.20'],
            ],
        ];

        $socios[] = [
            'run' => '17543547-6',
            'nombre' => 'Ricardo Orellana Acuña',
            'email' => 'eel.droo@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.79'],
                ['AS', 'L.131'],
                ['AM', 'L.67'],
            ],
        ];

        $socios[] = [
            'run' => '7699435-8',
            'nombre' => 'Ricardo Orellana Labra',
            'email' => 'lenceriasdarinkadk@gmail.com',
            'ubicaciones' => [
                ['AM', 'L.84'],
            ],
        ];

        $socios[] = [
            'run' => '10045344-4',
            'nombre' => 'Roxana Peña Fica',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.87'],
                ['AM', 'L.80'],
            ],
        ];

        $socios[] = [
            'run' => '19239144-K',
            'nombre' => 'Sebastián Guiñez Badilla',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.151'],
            ],
        ];

        $socios[] = [
            'run' => '9255017-6',
            'nombre' => 'Sergio Pulgar León',
            'email' => 'directochile02@yahoo.es',
            'ubicaciones' => [
                ['AS', 'L.14'],
                ['AS', 'L.31'],
                ['AS', 'L.47'],
                ['AS', 'L.66'],
                ['AS', 'L.117'],
                ['AS', 'L.146'],
                ['AS', 'L.156'],
                ['AM', 'L.69'],
                ['AM', 'L.70'],
                ['AM', 'L.71'],
            ],
        ];

        $socios[] = [
            'run' => '11887719-5',
            'nombre' => 'Silvia Araya Huerta',
            'email' => 'silviarah@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.5'],
            ],
        ];

        $socios[] = [
            'run' => '7071676-3',
            'nombre' => 'Susana Rodríguez Urzúa',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'L.33'],
            ],
        ];

        $socios[] = [
            'run' => '10801741-4',
            'nombre' => 'Susy Gómez Cerda',
            'email' => 'sarasil_19@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.21'],
                ['AS', 'L.199'],
                ['AM', 'L.30'],
            ],
        ];

        $socios[] = [
            'run' => '10304801-K',
            'nombre' => 'Tomás Astudillos Chávez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.7'],
                ['AM', 'L.50'],
            ],
        ];

        $socios[] = [
            'run' => '14469026-5',
            'nombre' => 'Tsung Ming Wu',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'M.D'],
            ],
        ];

        $socios[] = [
            'run' => '9861510-5',
            'nombre' => 'Tzu Chang Sun Lin',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.65'],
            ],
        ];

        $socios[] = [
            'run' => '4629268-5',
            'nombre' => 'Víctor Rojas Iribarra',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.165'],
                ['AM', 'L.40'],
            ],
        ];

        $socios[] = [
            'run' => '7209898-6',
            'nombre' => 'Victoria Stumpf Jerez',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.11'],
                ['AM', 'L.48'],
            ],
        ];

        $socios[] = [
            'run' => '9577777-5',
            'nombre' => 'Waldo Serrano Rosas',
            'email' => null,
            'ubicaciones' => [
                ['AM', 'L.12'],
            ],
        ];

        $socios[] = [
            'run' => '9034404-8',
            'nombre' => 'Ximena Gonzalez Gatica',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.78'],
                ['AS', 'L.141'],
                ['AM', 'L.28'],
            ],
        ];

        $socios[] = [
            'run' => '11663508-9',
            'nombre' => 'Ximena Herrera Quiroz',
            'email' => 'ximenaherrera.00@gmail.com',
            'ubicaciones' => [
                ['AS', 'L.29'],
                ['AS', 'L.74'],
                ['AS', 'L.120'],
                ['AS', 'L.201'],
                ['AM', 'L.8'],
            ],
        ];

        $socios[] = [
            'run' => '14660891-4',
            'nombre' => 'Ydelma Requejo Mendoza',
            'email' => 'distribuidoramarlen@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.58'],
                ['AS', 'L.104'],
                ['AM', 'L.41'],
            ],
        ];

        $socios[] = [
            'run' => '9477058-0',
            'nombre' => 'Zulinda Olmedo Vega',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.96'],
                ['AS', 'L.152'],
                ['AM', 'L.46'],
            ],
        ];

        $socios[] = [
            'run' => '8281879-0',
            'nombre' => 'Fernando Gonzalez Garcés',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.33'],
                ['AS', 'L.59'],
            ],
        ];

        $socios[] = [
            'run' => '21289651-9',
            'nombre' => 'Gina Rorario Flores Quispe',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.180'],
            ],
        ];

        $socios[] = [
            'run' => '18905126-3',
            'nombre' => 'Gloria Valentina Serrano Polanco',
            'email' => 'valentinaserranop@hotmail.com',
            'ubicaciones' => [
                ['AS', 'L.83'],
            ],
        ];

        $socios[] = [
            'run' => '13662217-K',
            'nombre' => 'Dayana Catherine Hernández Polanco',
            'email' => null,
            'ubicaciones' => [
                ['AS', 'L.196'],
            ],
        ];

        $socios[] = [
            'run' => '73923900-1',
            'nombre' => 'Cooperativa de Servicios Alameda Maipú',
            'email' => null,
            'ubicaciones' => [],
        ];

        // foreach($socios as $socio)
        // {
        //     $user = new User;
        //     $user->name = $socio['nombre'];
        //     $user->username = $socio['run'];
        //     $user->password = bcrypt(str_random(8));
        //     $user->email = $socio['email'] ? $socio['email'] : $this->defaultMail;
        //     $user->is_admin = false;
        //     $user->Initialized = false;
        //     $user->save();

        //     $partner = new Partner;
        //     $partner->user_id = $user->id;
        //     $partner->address = ' ';
        //     $partner->phone = ' ';
        //     $partner->save();

        //     foreach ($socio['ubicaciones'] as $location)
        //     {
        //         $locs = Location::where('code', $location[1])->get();
        //         foreach ($locs as $loc) {
        //             if($loc->sector->code == $location[0])
        //             {
        //                 $loc->partner_id = $partner->id;
        //                 $loc->save();
        //             }
        //         }
        //     }
        // }

        // if($this->remainingToCooperativa)
        // {
        //     $coopUser = User::where('username', '73923900-1')->first();

        //     $coopLocations = Location::whereNull('partner_id')->get();
        //     foreach ($coopLocations as $coopLocation)
        //     {
        //         $coopLocation->partner_id = $coopUser->partner->id;
        //         $coopLocation->save();
        //     }
        // }

        foreach($socios as $socio)
        {
            $user = User::where('username', 'LIKE', $socio['run'])->first();
            if($user)
            {
                $user->email = $socio['email'] ? $socio['email'] : $this->defaultMail;
                $user->save();
            }
        }
    }

    private function cleanup()
    {
        $locations = Location::whereNotNull('partner_id')->get();
        foreach($locations as $location)
        {
            $location->partner_id = null;
            $location->save();
        }

        $partners = User::where('is_admin', false)->get();
        foreach($partners as $partner)
        {
            $partner->delete();
        }
    }
}
