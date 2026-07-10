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
                'heading' => 'University Officials and Offices',
                'entries' => [
                    ['name' => 'Nemesio G. Loayon, Ph.D.', 'designation' => 'University President', 'contact' => '(086) 214-4221', 'email' => 'op@nemsu.edu.ph'],
                    ['name' => 'Prof. Ma. Lady Sol A. Suazo.', 'designation' => 'Vice President for Academic Affairs', 'contact' => '-', 'email' => 'vpaa@nemsu.edu.ph'],
                    ['name' => 'Prof. Rolly G. Salvaleon', 'designation' => 'Vice President for Research and Extension', 'contact' => '-', 'email' => 'rgsalvaleon@nemsu.edu.ph'],
                    ['name' => 'Dr. Abundio C. Miralles', 'designation' => 'Vice President for Administration and Finance', 'contact' => '-', 'email' => 'acmiralles@nemsu.edu.ph'],
                    ['name' => 'Dr. Florife O. Urbiztondo', 'designation' => 'Vice President for Planning and Strategic Initiatives/CAO-Admin', 'contact' => '-', 'email' => ''],
                    ['name' => 'Dr. Camilo D. Malong, Jr. CPA', 'designation' => 'CAO - Finance', 'contact' => '-', 'email' => 'chiefAO_FinanceDivision@nemsu.edu.ph'],
                    ['name' => 'Ms. Leorelie Kim D. Estrada, CPA', 'designation' => 'Supervising Administrative Officer - Financial Management', 'contact' => '(086) 214-6317', 'email' => 'lkcdahan@nemsu.edu.ph'],
                    ['name' => 'Engr. Christopher D. Badayos', 'designation' => 'Supervising Administrative Officer - Administrative Officer IV', 'contact' => '-', 'email' => 'cpbadayos@nemsu.edu.ph'],
                    ['name' => 'Prof. Evelyn T. Bagood', 'designation' => 'Director, Student Affairs and Welfare Services', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Prof. Ma. Cristina S. Dela Cerna', 'designation' => 'Director, Extension Services & Linkages', 'contact' => '-', 'email' => 'mcsdelacerna@nemsu.edu.ph'],
                    ['name' => 'Dr. Erwin B. Berry', 'designation' => 'Director, Research and Development', 'contact' => '-', 'email' => 'ebberry@nemsu.edu.ph'],
                    ['name' => 'Ms. Rhea M. Canang', 'designation' => 'OIC Director - Library Services', 'contact' => '-', 'email' => 'library.tandag@nemsu.edu.ph'],
                    ['name' => 'Prof. Shyla O. Moreno', 'designation' => 'Director for Culture and Arts & Sports Development', 'contact' => '-', 'email' => 'somoreno@nemsu.edu.ph'],
                    ['name' => 'Mr. Roel T. Lim', 'designation' => 'Director for Auxiliary Services / Human Resource Management Officer', 'contact' => '-', 'email' => 'rtlim@nemsu.edu.ph'],
                    ['name' => 'Dr. Ermie Lux L. Matildo', 'designation' => 'Director, International Affairs', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Dr. Karla Jean Roz', 'designation' => 'OIC Director for Curriculum Development', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Mr. Hussein M. Alawi, MPA', 'designation' => 'AO V / Records Officer III', 'contact' => '-', 'email' => 'hmalawi@nemsu.edu.ph'],
                    ['name' => 'Ms. Glesilda L. Canda', 'designation' => 'AOV/ Cashier III', 'contact' => '(086) 214-5170', 'email' => 'cashier.tandag@nemsu.edu.ph'],
                    ['name' => 'Ms. Lynnet A. Sarvida', 'designation' => 'AO V / Registrar III', 'contact' => '(086) 214-5069', 'email' => 'registrarmain@nemsu.edu.ph'],
                    ['name' => 'Ms. Coleen Joyze M. Momo', 'designation' => 'Internal Auditor III', 'contact' => '', 'email' => ''],
                    ['name' => 'Mr. Anthony B. Yanto, EDPSE', 'designation' => 'IT Officer I', 'contact' => '-', 'email' => 'abyanto@nemsu.edu.ph'],
                    ['name' => 'Engr. McDonald G. Amparo', 'designation' => 'AO V (General Services Unit)', 'contact' => '', 'email' => ''],
                    ['name' => 'Engr. Lea G. Gurimbao', 'designation' => 'AO V (Quality Assurance Unit)', 'contact' => '', 'email' => ''],
                    ['name' => 'Engr. Kennie F. Montenegro, PEE', 'designation' => 'AO V / Planning Officer III', 'contact' => '-', 'email' => 'kfmontenegro@nemsu.edu.ph'],
                    ['name' => 'Ms. Ma. Reina S. Acevedo', 'designation' => 'AO V / Procurement Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Mr. Floyd M. Mendez, CPA', 'designation' => 'Accountant III', 'contact' => '-', 'email' => 'fmmendez@nemsu.edu.ph'],
                    ['name' => 'Ms. Sandra Jessa S. Trajano', 'designation' => 'Budget Officer III', 'contact' => '(086) 214-6317', 'email' => 'sdssubudgetoffice@gmail.com'],
                    ['name' => 'Mr. Joseph B. Cabadonga', 'designation' => 'Information Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Arch. Vingie A. Maitom', 'designation' => 'Project Development Officer III', 'contact' => '', 'email' => ''],
                    ['name' => 'Atty. Michiko N. Donaire-Maglinte', 'designation' => 'Legal Officer IV', 'contact' => '-', 'email' => 'mndonaire-maglinte@nemsu.edu.ph'],
                    ['name' => 'Ms. Jenevieve P. Babao', 'designation' => 'Guidance Counselor III', 'contact' => '', 'email' => ''],
                    ['name' => 'Dr. Floresito D. Calub', 'designation' => 'OIC Campus Director of Tandag', 'contact' => '-', 'email' => ''],
                    ['name' => 'Juancho A. Intano, Ph.D.', 'designation' => 'Campus Director of NEMSU - Cantilan Campus', 'contact' => '-', 'email' => 'jaintano@nemsu.edu.ph'],
                    ['name' => 'Dr. Marvie V. Gonzaga', 'designation' => 'OIC Campus Director of San Miguel', 'contact' => '', 'email' => ''],
                    ['name' => 'Rozette E. Mecardo', 'designation' => 'OIC Campus Director of NEMSU - Cagwait Campus', 'contact' => '-', 'email' => 'remercado@nemsu.edu.ph'],
                    ['name' => 'Ms. Catherine F. Salomon', 'designation' => 'Board Secretary V/OIC Campus Director of Lianga', 'contact' => '-', 'email' => 'cfsalomon@nemsu.edu.ph'],
                    ['name' => 'Ariston O. Ronquillo, DM.', 'designation' => 'Campus Director of NEMSU- Tagbina Campus', 'contact' => '-', 'email' => 'aoronquillo@nemsu.edu.ph'],
                    ['name' => 'For. Whelson C. Pasos', 'designation' => 'Campus Director of NEMSU - Bislig Campus', 'contact' => '(086) 647-6452', 'email' => 'wcpasos@nemsu.edu.ph'],
                    ['name' => 'Prof. Alex S. Ladaga', 'designation' => 'Dean - Engineering & Technology Program', 'contact' => '(086) 214-5067', 'email' => 'asladaga@nemsu.edu.ph'],
                    ['name' => 'Annie Y. Samarca, Ph.D.', 'designation' => 'Dean - Teacher Education Programs', 'contact' => '(086) 214-2724', 'email' => 'aysamarca@nemsu.edu.ph'],
                    ['name' => 'Prof. Romeo A. Patan', 'designation' => 'Dean - Arts and Sciences Programs', 'contact' => '(086) 214-5933', 'email' => 'rapatan@nemsu.edu.ph'],
                    ['name' => 'Prof. Ramel D. Tomaquin', 'designation' => 'Dean - Business and Management Programs', 'contact' => '(086) 214-5195', 'email' => 'rdtomaquin@nemsu.edu.ph'],
                    ['name' => 'Atty. Daniel L. Diaz', 'designation' => 'Dean - College of Law', 'contact' => '-', 'email' => 'SDSSUlawschool@yahoo.com'],
                    ['name' => 'Prof. Jennifer M. Montero', 'designation' => 'Dean - Graduate School Programs', 'contact' => '-', 'email' => 'jmmontero@nemsu.edu.ph'],
                    ['name' => 'Prof. Clemencia L. Sumagaysay', 'designation' => 'Dean- Agriculture and Forestry Programs', 'contact' => '-', 'email' => 'clsumagaysay@nemsu.edu.ph'],
                    ['name' => 'Prof. Born Christian A. Isip', 'designation' => 'Dean - Information Technology Education Program', 'contact' => '(086) 214-5067', 'email' => 'bcaisip@nemsu.edu.ph'],
                    ['name' => 'Dr. Laurence P. Bazan', 'designation' => 'Dean - College of Criminal Justice Education & Director of NSTP', 'contact' => '-', 'email' => 'lpbazan@nemsu.edu.ph'],
                    ['name' => 'Dr. Fabio C. Ruaza Jr.', 'designation' => 'Dean- College of Fisheries and Marine Sciences Programs', 'contact' => '-', 'email' => '-'],
                    ['name' => 'Dr. Ma. Cecillia C. Cruz', 'designation' => 'Dean - College of Medicine', 'contact' => '-', 'email' => ''],
                    ['name' => '-', 'designation' => 'Supply Officer', 'contact' => '', 'email' => ''],
                ],
            ],
            [
                'heading' => 'Other Designations of University-wide Functions',
                'entries' => [
                    ['name' => 'Engr. Luzminda S. Bacquial', 'designation' => 'Innovation & Technology Support Office (ITSO) Manager', 'contact' => '-', 'email' => 'lsbacquial@nemsu.edu.ph'],
                    ['name' => 'Ms. Coravil Joy C. Avila', 'designation' => 'Technology Business Incubator (TBI) Manager', 'contact' => '-', 'email' => 'cjcavila@nemsu.edu.ph'],
                    ['name' => 'Dr. Roxan E. Caray', 'designation' => 'Editor-in-Chief, SDSSU Multidisciplinary Research Journal', 'contact' => '-', 'email' => 'rgeupena@nemsu.edu.ph'],
                    ['name' => '-', 'designation' => 'Gender and Development (GAD) Focal Person', 'contact' => '-', 'email' => '-'],
                ],
            ],
        ];
    }
}
