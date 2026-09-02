<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DirectoryController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('directory/Index', [
            'directorySections' => $this->directorySections(),
        ]);
    }

    /**
     * @return list<array{heading: string, entries: list<array{name: string, designation: string, contact: string, email: string}>}>
     */
    private function directorySections(): array
    {
        return [
            [
                'heading' => 'Key Officials of the University',
                'entries' => [
                    ['name' => 'Dr. Nemesio G. Loayon', 'designation' => 'SUC President III', 'contact' => '(086) 214-4221', 'email' => 'op@nemsu.edu.ph'],
                    ['name' => 'Atty. Michiko N. Donaire-Maglinte', 'designation' => 'OIC Vice President for Administration and Finance/Legal Officer IV', 'contact' => '-', 'email' => 'mndonaire-maglinte@nemsu.edu.ph'],
                    ['name' => 'Dr. Maria Lady Sol A. Suazo', 'designation' => 'Vice President for Academic Affairs', 'contact' => '-', 'email' => 'vpaa@nemsu.edu.ph'],
                    ['name' => 'Dr. Rolly G. Salvaleon', 'designation' => 'Vice President for Research and Extension', 'contact' => '-', 'email' => 'rgsalvaleon@nemsu.edu.ph'],
                    ['name' => 'Dr. Florife O. Urbiztondo', 'designation' => 'Vice President for Planning and Strategic Initiatives/CAO-Admin', 'contact' => '-', 'email' => ''],
                    ['name' => 'Dr. Floresito D. Calub', 'designation' => 'OIC-Campus Director-Tandag', 'contact' => '-', 'email' => ''],
                    ['name' => 'Dr. Juancho A. Intano', 'designation' => 'Campus Director-Cantilan', 'contact' => '-', 'email' => 'jaintano@nemsu.edu.ph'],
                    ['name' => 'Dr. Marvie V. Gonzaga', 'designation' => 'OIC-Campus Director-San Miguel', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Rozette E. Mercado', 'designation' => 'OIC-Campus Director-Cagwait', 'contact' => '-', 'email' => 'remercado@nemsu.edu.ph'],
                    ['name' => 'Dr. Ivy M. Orcullo', 'designation' => 'OIC-Campus Director-Lianga', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Ariston O. Ronquillo', 'designation' => 'Campus Director-Tagbina', 'contact' => '-', 'email' => 'aoronquillo@nemsu.edu.ph'],
                    ['name' => 'Dr. Franco Pantaleon', 'designation' => 'OIC-Campus Director-Bislig', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Alex S. Ladaga', 'designation' => 'Dean, CET', 'contact' => '(086) 214-5067', 'email' => 'asladaga@nemsu.edu.ph'],
                    ['name' => 'Dr. Annie Y. Samarca', 'designation' => 'Dean, CTE', 'contact' => '(086) 214-2724', 'email' => 'aysamarca@nemsu.edu.ph'],
                    ['name' => 'Dr. Romeo A. Patan', 'designation' => 'Dean, CAS', 'contact' => '(086) 214-5933', 'email' => 'rapatan@nemsu.edu.ph'],
                    ['name' => 'Dr. Ramel D. Tomaquin', 'designation' => 'Dean, CBM', 'contact' => '(086) 214-5195', 'email' => 'rdtomaquin@nemsu.edu.ph'],
                    ['name' => 'Atty. Daniel L. Diaz', 'designation' => 'Dean, COL', 'contact' => '-', 'email' => 'SDSSUlawschool@yahoo.com'],
                    ['name' => 'Dr. Jennifer M. Montero', 'designation' => 'Dean, GS', 'contact' => '-', 'email' => 'jmmontero@nemsu.edu.ph'],
                    ['name' => 'Dr. Born Christian A. Isip', 'designation' => 'Dean, CITE', 'contact' => '(086) 214-5067', 'email' => 'bcaisip@nemsu.edu.ph'],
                    ['name' => 'Dr. Laurence P. Bazan', 'designation' => 'Dean, CCJE/NSTP Director', 'contact' => '-', 'email' => 'lpbazan@nemsu.edu.ph'],
                    ['name' => 'Dr. Fabio C. Ruaza Jr.', 'designation' => 'Dean, CFAS', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Dr. Allan J. Cuison', 'designation' => 'Dean, COM', 'contact' => '', 'email' => ''],
                    ['name' => 'Atty. Resty Myrrh B. Purca, CPA, MBA', 'designation' => 'Dean, COA', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Douglas Doloriel', 'designation' => 'OIC-Dean, CAF', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Camilo D. Malong, Jr.', 'designation' => 'CAO-Finance', 'contact' => '-', 'email' => 'chiefAO_FinanceDivision@nemsu.edu.ph'],
                    ['name' => 'Ms. Leorelie Kim D. Estrada', 'designation' => 'SAO-Finance', 'contact' => '(086) 214-6317', 'email' => 'lkcdahan@nemsu.edu.ph'],
                    ['name' => 'Engr. Christopher D. Badayos', 'designation' => 'SAO-Admin', 'contact' => '-', 'email' => 'cpbadayos@nemsu.edu.ph'],
                    ['name' => 'Mr. Arturo G. Gracia Jr.', 'designation' => 'Director, Research and Innovation', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Abundio C. Miralles', 'designation' => 'Director, Extension Services and Linkages', 'contact' => '-', 'email' => 'acmiralles@nemsu.edu.ph'],
                    ['name' => 'Dr. Evelyn T. Bagood', 'designation' => 'Director, Student Affairs and Welfare Services', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Ms. Maria Lea Griettel E. Cortez', 'designation' => 'Director, Library Services', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Shyla O. Moreno', 'designation' => 'Director, Culture and Arts/Sport and Development', 'contact' => '-', 'email' => 'somoreno@nemsu.edu.ph'],
                    ['name' => 'Dr. Ermie Lux L. Matildo', 'designation' => 'Director, International Affairs', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Engr. Luzminda S. Bacquial', 'designation' => 'Director, Knowledge and Technology Transfer/ITSO Manager', 'contact' => '-', 'email' => 'lsbacquial@nemsu.edu.ph'],
                    ['name' => 'Dr. Erwin B. Berry', 'designation' => 'Director, Instructional Materials Development', 'contact' => '-', 'email' => 'ebberry@nemsu.edu.ph'],
                    ['name' => 'Mr. Hussein M. Alawi', 'designation' => 'Director, Research Centers', 'contact' => '-', 'email' => 'hmalawi@nemsu.edu.ph'],
                    ['name' => 'Dr. Roel T. Lim, JD', 'designation' => 'Director, Auxiliary Services & Income Generating Projects', 'contact' => '-', 'email' => 'rtlim@nemsu.edu.ph'],
                    ['name' => 'Dr. Karla Jeane P. Roz-Estrada', 'designation' => 'OIC-Director, Curriculum Dev’t.', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Ms. Jovelyn B. Clarit', 'designation' => 'AO V/Supply Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Glesilda L. Canda', 'designation' => 'AO V/Cashier III', 'contact' => '(086) 214-5170', 'email' => 'cashier.tandag@nemsu.edu.ph'],
                    ['name' => 'Ms. Lynnet A. Sarvida', 'designation' => 'AO V/Registrar III', 'contact' => '(086) 214-5069', 'email' => 'registrarmain@nemsu.edu.ph'],
                    ['name' => 'Engr. Kennie F. Montenegro', 'designation' => 'AO V/Planning Officer III', 'contact' => '-', 'email' => 'kfmontenegro@nemsu.edu.ph'],
                    ['name' => 'Ms. Ma. Reina S. Acevedo', 'designation' => 'AO V/Procurement Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Engr. McDonald G. Amparo', 'designation' => 'AO V (General Services Unit)', 'contact' => '', 'email' => ''],
                    ['name' => 'Engr. Lea G. Gurimbao', 'designation' => 'AO V (Quality Assurance Unit)', 'contact' => '', 'email' => ''],
                    ['name' => 'Mr. John Philip B. Luga', 'designation' => 'AO V (Auxiliary Services Unit)', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Concepcion A. Badayos', 'designation' => 'AO V/Records Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Mr. Calvin R. Sillar, CPA, MBA', 'designation' => 'Accountant III', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Sandra Jessa S. Trajano', 'designation' => 'Budget Officer III', 'contact' => '(086) 214-6317', 'email' => 'sdssubudgetoffice@gmail.com'],
                    ['name' => 'Mr. Joseph B. Cabadonga', 'designation' => 'Information Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Eunice P. Prado, RPm', 'designation' => 'Human Resource Management Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Arch. Vingie A. Maitom', 'designation' => 'Project Development Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Jenevieve P. Babao', 'designation' => 'Guidance Counselor III', 'contact' => '', 'email' => ''],
                    ['name' => 'Ms. Coleen Joyce M. Momo', 'designation' => 'Internal Auditor III', 'contact' => '', 'email' => ''],
                    ['name' => 'Mr. Anthony B. Yanto', 'designation' => 'Information Technology Officer I', 'contact' => '-', 'email' => 'abyanto@nemsu.edu.ph'],
                ],
            ],
            [
                'heading' => 'Other University-wide Designations',
                'entries' => [
                    ['name' => 'Ms. Coravil Avila', 'designation' => 'TBI Manager', 'contact' => '-', 'email' => 'cjcavila@nemsu.edu.ph'],
                    ['name' => 'Dr. Roxan E. Caray', 'designation' => 'Editor-in-Chief, SDSSU Multidisciplinary Research Journal', 'contact' => '-', 'email' => 'rgeupena@nemsu.edu.ph'],
                    ['name' => 'Ms. Marlina B. Sagetarios', 'designation' => 'GAD Focal Person', 'contact' => '', 'email' => ''],
                ],
            ],
        ];
    }
}
