<?php

namespace Database\Seeders;

use App\Models\ChatbotModule\Questionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDateTime = currentDateTime();

        $data = [
            [
                Questionnaire::priority => 1,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What is HIV, and how is it transmitted? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'HIV (Human Immunodeficiency Virus) is a virus that attacks the immune system. It can be transmitted through unprotected sexual intercourse (vaginal, anal, or oral) with an infected person, sharing needles or syringes, and from mother to child during pregnancy. It is not transmitted through casual contact like hugging or shaking hands, sharing utensils, or sitting together.'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 2,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Is there a treatment for HIV?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Yes, there is treatment available for HIV.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Antiretroviral therapy (ART) is the primary treatment for HIV infection that is to be taken lifelong.  It is important to start ART as early as possible after diagnosis and adhere to the prescribed treatment regimen. ART helps manage the virus and prevent it from advancing to AIDS. Check our website to get further support and information on testing centers near you.'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 3,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Where do I connect for support? Where can I get tested for HIV and STIs? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Follow the steps on the website and find access to your nearest testing and treatment centers.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Or connect with our counsellors for free on the numbers below: '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'NORTH REGION: +91 82872 19410'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'WEST REGION: +91 93260 78990'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'EAST REGION : +91 88128 53117'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'SOUTH REGION: +91 82487 03556'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 4,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'How can I protect myself from HIV and STIs (Gupt Rog)? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'To protect yourself from HIV and STIs, it is essential to practice safe sex. This includes using condoms consistently and correctly, getting tested regularly, and knowing the HIV and STI status of your partner. If you inject drugs, never share needles or syringes. Additionally, consider pre-exposure prophylaxis (PrEP) for HIV prevention if you are at high risk.'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 5,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What are the most common STIs? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'The most common sexually transmitted infections (STIs) include chlamydia, gonorrhoea, syphilis, genital herpes, human papillomavirus (HPV), and trichomoniasis. Each of these infections has its own symptoms, transmission methods, and treatment options. Regular STI testing is crucial, especially if you have multiple sexual partners.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Call our counsellors for support.'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 5,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'I am stressed, I think I may be at risk.'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Meet our counsellors who can provide you with personalised advice based on your specific situation and help address any anxieties you may have. Remember your information is safe with us.'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 6,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Want to see some images?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Image'),
                                    'content' => 'https://webneel.com/daily/sites/default/files/images/daily/08-2018/1-nature-photography-spring-season-mumtazshamsee.jpg'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Image'),
                                    'content' => 'https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014_640.jpg'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Image'),
                                    'content' => 'https://media.istockphoto.com/id/944812540/photo/mountain-landscape-ponta-delgada-island-azores.jpg?s=612x612&w=0&k=20&c=mbS8X4gtJki3gGDjfC0sG3rsz7D0nls53a0b4OPXLnE='
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Image'),
                                    'content' => 'https://hips.hearstapps.com/hmg-prod/images/nature-captions-1-1672892626.jpg?crop=1xw:1xh;center,top&resize=980:*'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 7,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Need some references?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => 'Link 1',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://webneel.com/daily/sites/default/files/images/daily/08-2018/1-nature-photography-spring-season-mumtazshamsee.jpg'
                                ],
                                [
                                    'title' => 'Link 2',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014_640.jpg'
                                ],
                                [
                                    'title' => 'Link 3',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://media.istockphoto.com/id/944812540/photo/mountain-landscape-ponta-delgada-island-azores.jpg?s=612x612&w=0&k=20&c=mbS8X4gtJki3gGDjfC0sG3rsz7D0nls53a0b4OPXLnE='
                                ],
                                [
                                    'title' => 'Link 4',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://hips.hearstapps.com/hmg-prod/images/nature-captions-1-1672892626.jpg?crop=1xw:1xh;center,top&resize=980:*'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 8,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Need some videos?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/es4x5R-rV9s'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/dphagk4O5qA'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/PSKnO9jvkig'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/7PIji8OubXU'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 9,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What is the difference between HIV and AIDS? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'एचआयव्ही आणि एड्समध्ये काय फरक आहे? '
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'एचआईवी और एड्स में क्या अंतर है? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'HIV stands for Human Immunodeficiency Virus. The virus gradually damages the immune system, i.e., the ability to fight infections/diseases. '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "AIDS stands for Acquired Immune Deficiency Syndrome. It is the later stage of HIV infection and is sometimes referred to as ‘late-stage HIV’ or ‘advanced HIV disease’. This condition is reached when a group of symptoms appear as the immune system becomes very weak. "
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'ART drugs help you lead a healthy life and prevents the HIV virus from reaching the AIDS stage. '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्ही म्हणजे ह्युमन इम्युनोडेफिशियन्सी व्हायरस. हा विषाणू हळूहळू रोगप्रतिकारक शक्तीला, म्हणजेच संसर्ग/रोगांशी लढण्याच्या क्षमतेला हानी पोहोचवतो.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "एड्स म्हणजे एक्वायर्ड इम्यून डेफिशिएंसी सिंड्रोम. हा एचआयव्ही संसर्गाचा नंतरचा टप्पा आहे आणि कधीकधी त्याला 'लेट स्टेज एचआयव्ही' किंवा 'प्रगत एचआयव्ही रोग' म्हणून संबोधले जाते. जेव्हा रोगप्रतिकारक शक्ती खूप कमकुवत झाल्यामुळे लक्षणांचा एक गट दिसून येतो तेव्हा ही स्थिती गाठली जाते."
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एआरटी औषधे आपल्याला निरोगी जीवन जगण्यास मदत करतात आणि एचआयव्ही विषाणूला एड्सच्या टप्प्यात पोहोचण्यापासून प्रतिबंधित करतात.'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआईवी का मतलब ह्यूमन इम्यूनोडेफिशिएंसी वायरस है। वायरस धीरे-धीरे प्रतिरक्षा प्रणाली को नुकसान पहुंचाता है, यानी संक्रमण / बीमारियों से लड़ने की क्षमता।'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "एड्स का मतलब एक्वायर्ड इम्यून डेफिशिएंसी सिंड्रोम है। यह एचआईवी संक्रमण का बाद का चरण है और इसे कभी-कभी 'लेट-स्टेज एचआईवी' या 'उन्नत एचआईवी रोग' के रूप में जाना जाता है। यह स्थिति तब होती है जब लक्षणों का एक समूह दिखाई देता है क्योंकि प्रतिरक्षा प्रणाली बहुत कमजोर हो जाती है। "
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एआरटी दवाएं आपको स्वस्थ जीवन जीने में मदद करती हैं और एचआईवी वायरस को एड्स चरण तक पहुंचने से रोकती हैं।'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 10,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'Is there a cure for HIV?  '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'एचआयव्हीवर काही इलाज आहे का? '
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'एचआईवी और एड्स में क्या अंतर है? '
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'There is effective treatment* available which can keep the virus in check and its effect on the body can be slowed down. Anti-Retroviral Treatment (ART) drugs can prolong the life of an HIV positive person, thus enhancing the quality of life as well. Patients must take lifelong treatment once initiated on ART. It is available free at all Government ART centres across India. '
                                ],
                                [
                                    'title' => 'Contact Us',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://netreach.org.in/contact-us'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "for more information regarding HIV support services  "
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'globally scientists are working to find a complete cure for HIV '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'असे प्रभावी उपचार* उपलब्ध आहेत जे विषाणूला नियंत्रणात ठेवू शकतात आणि त्याचा शरीरावर होणारा परिणाम कमी केला जाऊ शकतो. अँटी-रेट्रोव्हायरल ट्रीटमेंट (एआरटी) औषधे एचआयव्ही पॉझिटिव्ह व्यक्तीचे आयुष्य वाढवू शकतात, ज्यामुळे जीवनाची गुणवत्ता देखील वाढते. एआरटीवर सुरू झाल्यानंतर रुग्णांनी आयुष्यभर उपचार घ्यावेत. हे भारतभरातील सर्व सरकारी एआरटी केंद्रांवर विनामूल्य उपलब्ध आहे.'
                                ],
                                [
                                    'title' => 'एचआयव्ही समर्थन सेवांबद्दल',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://netreach.org.in/contact-us'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "अधिक माहितीसाठी आमच्याशी संपर्क साधा"
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्हीवर संपूर्ण उपचार शोधण्यासाठी जागतिक स्तरावर शास्त्रज्ञ काम करत आहेत'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'प्रभावी उपचार * उपलब्ध है जो वायरस को जांच में रख सकता है और शरीर पर इसके प्रभाव को धीमा कर सकता है। एंटी-रेट्रोवायरल उपचार (एआरटी) दवाएं एचआईवी पॉजिटिव व्यक्ति के जीवन को लम्बा खींच सकती हैं, इस प्रकार जीवन की गुणवत्ता को भी बढ़ा सकती हैं। एआरटी पर शुरू होने के बाद रोगियों को आजीवन उपचार लेना चाहिए। यह पूरे भारत में सभी सरकारी एआरटी केंद्रों पर मुफ्त उपलब्ध है।'
                                ],
                                [
                                    'title' => 'एचआईवी सहायता सेवाओं के बारे में ',
                                    'media_type' => createSlug('Link'),
                                    'content' => 'https://netreach.org.in/contact-us'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "अधिक जानकारी के लिए हमसे संपर्क करें "
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'विश्व स्तर पर वैज्ञानिक एचआईवी के लिए एक पूर्ण इलाज खोजने के लिए काम कर रहे हैं'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 11,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'How is HIV transmitted? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'एचआयव्ही चा प्रसार कसा होतो?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'एचआईवी कैसे फैलता है?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'HIV awareness is extremely important to save yourself from the risk of HIV. HIV can be transmitted through: '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'A. Unprotected sex with a person infected with HIV- You can get HIV if you have anal sex or vaginal sex with someone who has HIV without using protection (like condoms or medicine to treat or prevent HIV). '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'B. Transfusion of HIV infected blood or blood products  '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'C. Sharing of needles contaminated with HIV infected blood  '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'D. and from a parent infected with HIV to their baby – during pregnancy, or after delivery through breast milk.  '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्हीच्या जोखमीपासून स्वतःला वाचविण्यासाठी एचआयव्ही जागरूकता अत्यंत महत्वाची आहे. एचआयव्ही द्वारे संक्रमित केला जाऊ शकतो:'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '१) एचआयव्हीची लागण झालेल्या व्यक्तीशी असुरक्षित लैंगिक संबंध - संरक्षण न वापरता (जसे की कंडोम किंवा एचआयव्हीवर उपचार करण्यासाठी किंवा प्रतिबंध करण्यासाठी कंडोम किंवा औषध) एचआयव्ही असलेल्या एखाद्याव्यक्तीशी गुदद्वारासंबंधी लैंगिक संबंध किंवा योनीतून लैंगिक संबंध ठेवल्यास आपल्याला एचआयव्ही होऊ शकतो.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '२) एचआयव्ही बाधित रक्त किंवा रक्त उत्पादनांचे संक्रमण'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '३) एचआयव्ही बाधित रक्ताने दूषित सुया सामायिक करणे'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '४) आणि एचआयव्हीची लागण झालेल्या पालकांकडून त्यांच्या बाळाला - गर्भधारणेदरम्यान किंवा आईच्या दुधाद्वारे प्रसूतीनंतर.'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआईवी के  खतरे से खुद को बचाने के लिए एचआईवी जागरूकता बेहद जरूरी है। एचआईवी के माध्यम से प्रेषित किया जा सकता है: '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '१) एचआईवी से संक्रमित व्यक्ति के साथ असुरक्षित यौन संबंध- आप एचआईवी प्राप्त कर सकते हैं यदि आप किसी ऐसे व्यक्ति के साथ गुदा सेक्स या योनि सेक्स करते हैं जिसे सुरक्षा का उपयोग किए बिना एचआईवी है (जैसे एचआईवी के इलाज या रोकथाम के लिए कंडोम या दवा)।'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '२) एचआईवी संक्रमित रक्त या रक्त उत्पादों का आधान'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '३) एचआईवी संक्रमित रक्त से दूषित सुइयों को साझा करना'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => '४) और एचआईवी से संक्रमित माता-पिता से उनके बच्चे तक - गर्भावस्था के दौरान, या स्तन के दूध के माध्यम से प्रसव के बाद।'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 12,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'How do I avoid getting HIV during sex? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'सेक्स दरम्यान एचआयव्ही होणे कसे टाळावे?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'मैं सेक्स के दौरान एचआईवी होने से कैसे बच सकता हूं?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'HIV is transmitted through semen, vaginal fluid, blood, and anal mucus. Unprotected sex is any kind of sex without a condom. Wearing a condom helps prevent passing bodily fluids to one another, thus reducing the risk of transmitting the infection (HIV and also STI infection). '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्ही वीर्य, योनिमार्गातील द्रव, रक्त आणि गुदा श्लेष्माद्वारे प्रसारित होतो. असुरक्षित सेक्स म्हणजे कंडोमशिवाय कोणत्याही प्रकारचा सेक्स. कंडोम परिधान केल्याने एकमेकांना शारीरिक द्रव पदार्थ जाण्यास प्रतिबंध होतो, ज्यामुळे संसर्ग (एचआयव्ही आणि एसटीआय संसर्ग) होण्याचा धोका कमी होतो.'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआईवी वीर्य, योनि तरल पदार्थ, रक्त और गुदा बलगम के माध्यम से फैलता है। असुरक्षित यौन संबंध कंडोम के बिना किसी भी तरह का यौन संबंध है। कंडोम पहनने से एक दूसरे को शारीरिक तरल पदार्थ पारित करने से रोकने में मदद मिलती है, इस प्रकार संक्रमण (एचआईवी और एसटीआई संक्रमण) को प्रसारित करने का खतरा कम हो जाता है।'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 13,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'When can I go for my HIV test? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'मी माझ्या एचआयव्ही चाचणीसाठी कधी जाऊ शकतो?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'मैं अपने एचआईवी परीक्षण के लिए कब जा सकता हूं?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'HIV testing is available at both government and private hospitals. The government hospitals typically work Monday to Saturdays. You can visit any Government ICTC (Integrated Counselling and Testing Centres) centre on any working day except Sundays & Public holidays. For Private Hospitals & Private Testing Labs, one needs to check their date and timing. This information is sometimes available on the internet. '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Also you can refer to the below video to book an appointment for your HIV Test'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/whggSgYDuSw'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्ही चाचणी सरकारी आणि खाजगी दोन्ही रुग्णालयांमध्ये उपलब्ध आहे. सरकारी रुग्णालये साधारणत: सोमवार ते शनिवारी काम करतात. आपण रविवार आणि सार्वजनिक सुट्टी वगळता कोणत्याही कामाच्या दिवशी कोणत्याही शासकीय आयसीटीसी (एकात्मिक समुपदेशन आणि चाचणी केंद्र) केंद्रास भेट देऊ शकता. खाजगी रुग्णालये आणि खाजगी चाचणी प्रयोगशाळांसाठी, त्यांची तारीख आणि वेळ तपासणे आवश्यक आहे. ही माहिती कधी कधी इंटरनेटवर उपलब्ध असते.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'तसेच तुमच्या HIV चाचणीसाठी अपॉइंटमेंट बुक करण्यासाठी तुम्ही खालील व्हिडिओचा संदर्भ घेऊ शकता'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/whggSgYDuSw'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआईवी परीक्षण सरकारी और निजी दोनों अस्पतालों में उपलब्ध है। सरकारी अस्पताल आमतौर पर सोमवार से शनिवार तक काम करते हैं। आप रविवार और सार्वजनिक छुट्टियों को छोड़कर किसी भी कार्य दिवस पर किसी भी सरकारी आईसीटीसी (एकीकृत परामर्श और परीक्षण केंद्र) केंद्र का दौरा कर सकते हैं। निजी अस्पतालों और निजी परीक्षण प्रयोगशालाओं के लिए, किसी को उनकी तारीख और समय की जांच करने की आवश्यकता है। यह जानकारी कभी-कभी इंटरनेट पर उपलब्ध होती है।'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'इसके अलावा आप अपने एचआईवी परीक्षण के लिए अपॉइंटमेंट बुक करने के लिए नीचे दिए गए वीडियो का संदर्भ ले सकते हैं'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Video'),
                                    'content' => 'https://www.youtube.com/embed/whggSgYDuSw'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 14,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What do I do if I get HIV? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'मला एचआयव्ही झाल्यास मी काय करावे?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'अगर मुझे एचआईवी हो जाता है तो मुझे क्या करना चाहिए?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Contact our Counsellor for further advice and HIV counselling. Or connect with the nearest Government ICTC centre or ART centre. ART medicines slow down the effects of HIV in your body, which keeps you healthy and also lowers the chances of transmitting the virus to your partner. Taking ART medicines early and continuing with the treatment is important to protect the immune system. Treatment also involves taking care of your nutrition, emotional and mental health. All ICTC and ART centre services include Counselling services which is a must for integrated HIV care and support. '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => ' पुढील सल्ला आणि एचआयव्ही समुपदेशनासाठी आमच्या समुपदेशकांशी संपर्क साधा. किंवा जवळच्या सरकारी आयसीटीसी केंद्र किंवा एआरटी केंद्राशी संपर्क साधा. एआरटी औषधे आपल्या शरीरात एचआयव्हीचा प्रभाव कमी करतात, जे आपल्याला निरोगी ठेवते आणि आपल्या जोडीदारास व्हायरस प्रसारित करण्याची शक्यता देखील कमी करते. रोगप्रतिकारक शक्तीचे रक्षण करण्यासाठी एआरटी औषधे लवकर घेणे आणि उपचार सुरू ठेवणे महत्वाचे आहे. उपचारांमध्ये आपले पोषण, भावनिक आणि मानसिक आरोग्याची काळजी घेणे देखील समाविष्ट आहे. सर्व आयसीटीसी आणि एआरटी सेंटर सेवांमध्ये समुपदेशन सेवांचा समावेश आहे जो एकात्मिक एचआयव्ही काळजी आणि समर्थनासाठी आवश्यक आहे. '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'आगे की सलाह और एचआईवी परामर्श के लिए हमारे परामर्शदाता से संपर्क करें। या निकटतम सरकारी आईसीटीसी केंद्र या एआरटी केंद्र से जुड़ें। एआरटी दवाएं आपके शरीर में एचआईवी के प्रभाव को धीमा कर देती हैं, जो आपको स्वस्थ रखती हैं और आपके साथी को वायरस प्रसारित करने की संभावना को भी कम करती हैं। प्रतिरक्षा प्रणाली की रक्षा के लिए एआरटी दवाओं को जल्दी लेना और उपचार जारी रखना महत्वपूर्ण है। उपचार में आपके पोषण, भावनात्मक और मानसिक स्वास्थ्य की देखभाल करना भी शामिल है। सभी आईसीटीसी और एआरटी केंद्र सेवाओं में परामर्श सेवाएं शामिल हैं जो एकीकृत एचआईवी देखभाल और सहायता के लिए आवश्यक हैं। '
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 15,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What is an STI or STD? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'एसटीआय किंवा एसटीडी म्हणजे काय?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'एसटीआई या एसटीडी क्या है?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'STD stands for sexually transmitted disease, whereas STI means sexually transmitted infection. Essentially, the difference is between a disease and an infection. Sexually transmitted disease first begins as a sexually transmitted infection. Infection occurs when the sexually transmitted bacteria or virus first enters the body and begins multiplying. Once the sexually transmitted bacteria or viruses have entered the body, the infection may progress into a disease. Disease occurs when this foreign presence officially disrupts the body’s normal functions and processes. '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एसटीडी म्हणजे लैंगिक संक्रमित रोग, तर एसटीआय म्हणजे लैंगिक संक्रमित संक्रमण. मुळात, फरक रोग आणि संसर्ग यांच्यात आहे. लैंगिक संक्रमित रोग प्रथम लैंगिक संक्रमित संसर्ग म्हणून सुरू होतो. जेव्हा लैंगिक संक्रमित जीवाणू किंवा विषाणू प्रथम शरीरात प्रवेश करतात आणि गुणाकार करण्यास सुरवात करतात तेव्हा संसर्ग होतो. एकदा लैंगिक संक्रमित जीवाणू किंवा विषाणू शरीरात प्रवेश केल्यानंतर, संसर्ग रोगात बदलू शकतो. जेव्हा ही परदेशी उपस्थिती अधिकृतपणे शरीराच्या सामान्य कार्ये आणि प्रक्रियांमध्ये व्यत्यय आणते तेव्हा रोग होतो.'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एसटीडी का मतलब यौन संचारित रोग है, जबकि एसटीआई का अर्थ है यौन संचारित संक्रमण। अनिवार्य रूप से, अंतर एक बीमारी और एक संक्रमण के बीच है। यौन संचारित रोग पहले यौन संचारित संक्रमण के रूप में शुरू होता है। संक्रमण तब होता है जब यौन संचारित बैक्टीरिया या वायरस पहली बार शरीर में प्रवेश करते हैं और गुणा करना शुरू करते हैं। एक बार जब यौन संचारित बैक्टीरिया या वायरस शरीर में प्रवेश कर जाते हैं, तो संक्रमण एक बीमारी में प्रगति कर सकता है। रोग तब होता है जब यह विदेशी उपस्थिति आधिकारिक तौर पर शरीर के सामान्य कार्यों और प्रक्रियाओं को बाधित करती है।'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 16,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'How are STIs treated? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'एसटीआयचा उपचार कसा केला जातो?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'एसटीआई का इलाज कैसे किया जाता है?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'Sexually transmitted infections (STIs) caused by bacteria are generally easier to treat. Viral infections can be managed but not always cured. Treatment varies and may include medication (antibiotics) and practicing safe sex to avoid spreading the infection to others. '
                                ]
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'बॅक्टेरियामुळे होणारे लैंगिक संक्रमित संक्रमण (एसटीआय) सामान्यत: उपचार करणे सोपे असते. व्हायरल इन्फेक्शन व्यवस्थापित केले जाऊ शकते परंतु नेहमीच बरे होत नाही. उपचार वेगवेगळे असतात आणि इतरांमध्ये संसर्ग पसरू नये म्हणून औषधोपचार (अँटीबायोटिक्स) आणि सुरक्षित लैंगिक संबंधांचा सराव करणे समाविष्ट असू शकते.'
                                ]
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [

                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'बैक्टीरिया के कारण होने वाले यौन संचारित संक्रमण (एसटीआई) आमतौर पर इलाज करना आसान होता है। वायरल संक्रमण का प्रबंधन किया जा सकता है लेकिन हमेशा ठीक नहीं होता है। उपचार भिन्न होता है और इसमें दवा (एंटीबायोटिक्स) और दूसरों को संक्रमण फैलाने से बचने के लिए सुरक्षित सेक्स का अभ्यास शामिल हो सकता है।'
                                ]
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ],
            [
                Questionnaire::priority => 17,
                Questionnaire::question => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => 'What is high risk behaviour? '
                        ],
                        [
                            'locale' => 'mr',
                            'body' => 'हाय रिस्क वर्तन म्हणजे काय?'
                        ],
                        [
                            'locale' => 'hn',
                            'body' => 'उच्च जोखिम व्यवहार क्या है?'
                        ]
                    ]
                ),
                Questionnaire::answer_sheet => json_encode(
                    [
                        [
                            'locale' => 'en',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'High-risk behaviours are defined as acts that increase the risk of disease. With regards to HIV and STIs it is the following populations that are considered to be of high-risk: '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who indulges in unsafe sex practices that increases the risk of contracting the HIV virus and other stis '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who is unaware of safe sex practices and will eventually contract the HIV virus and other stis '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who willingly continues to practice unsafe sex practices and will contract HIV/has contracted HIV virus/ has developed AIDS/has stis/ has stis along with either HIV or AIDS '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who is unaware of HIV intervention options  '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => "An individual who is not aware of their status or isn't aware that their partner falls in the high-risk category "
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who is aware of the risks associated with their sexual behaviour and has to continue in the practice. '
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'An individual who uses drugs using injections/shared needles and associated materials that will make them contract HIV and other infections. '
                                ],
                            ]
                        ],
                        [
                            'locale' => 'mr',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'उच्च-जोखमीच्या वर्तनाची व्याख्या अशी केली जाते ज्यामुळे रोगाचा धोका वाढतो. एचआयव्ही आणि एसटीआयच्या संदर्भात खालील लोकसंख्या उच्च-जोखमीची मानली जाते:'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ती जी असुरक्षित लैंगिक प्रथांमध्ये गुंतलेली आहे ज्यामुळे एचआयव्ही व्हायरस आणि इतर एसटीआयचा संसर्ग होण्याचा धोका वाढतो'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'अशी व्यक्ती जी सुरक्षित लैंगिक पद्धतींबद्दल अनभिज्ञ आहे आणि शेवटी एचआयव्ही व्हायरस आणि इतर एसटीआयची लागण करेल'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'ज्या व्यक्तीने स्वेच्छेने असुरक्षित लैंगिक प्रथा सुरू ठेवल्या आहेत आणि एचआयव्हीची लागण होईल / एचआयव्ही विषाणूची लागण झाली आहे / एड्स विकसित झाला आहे / एसटीआय आहे / एचआयव्ही किंवा एड्ससह एसटीआय आहे'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एचआयव्ही हस्तक्षेप पर्यायांबद्दल अनभिज्ञ असलेली व्यक्ती'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'अशी व्यक्ती ज्याला त्यांच्या स्थितीची माहिती नसते किंवा आपला जोडीदार उच्च-जोखमीच्या श्रेणीत येतो याची जाणीव नसते'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ती ज्याला त्यांच्या लैंगिक वर्तनाशी संबंधित जोखमींची जाणीव आहे आणि सराव चालू ठेवावा लागतो.'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ती जी इंजेक्शन / सामायिक सुया आणि संबंधित सामग्री वापरुन औषधे वापरते ज्यामुळे त्यांना एचआयव्ही आणि इतर संक्रमण ांचा संसर्ग होईल.'
                                ],
                            ]
                        ],
                        [
                            'locale' => 'hn',
                            'body' => [
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'उच्च जोखिम वाले व्यवहार को उन कृत्यों के रूप में परिभाषित किया जाता है जो बीमारी के जोखिम को बढ़ाते हैं। एचआईवी और एसटीआई के संबंध में यह निम्नलिखित आबादी है जिन्हें उच्च जोखिम वाला माना जाता है:'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो असुरक्षित यौन प्रथाओं में लिप्त है जो एचआईवी वायरस और अन्य एसटीआई के अनुबंध के जोखिम को बढ़ाता है'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो सुरक्षित यौन प्रथाओं से अनजान है और अंततः एचआईवी वायरस और अन्य एसटीआई का अनुबंध करेगा'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो स्वेच्छा से असुरक्षित यौन प्रथाओं का अभ्यास करना जारी रखता है और एचआईवी से संक्रमित हो जाता है / एचआईवी वायरस से संक्रमित हो जाता है / एड्स विकसित हो गया है / एचआईवी या एड्स के साथ एसटीआई है /'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो एचआईवी हस्तक्षेप विकल्पों से अनजान है'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो अपनी स्थिति से अवगत नहीं है या यह नहीं जानता है कि उनका साथी उच्च जोखिम श्रेणी में आता है'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो अपने यौन व्यवहार से जुड़े जोखिमों से अवगत है और उसे अभ्यास में जारी रखना है।'
                                ],
                                [
                                    'title' => null,
                                    'media_type' => createSlug('Plain Text'),
                                    'content' => 'एक व्यक्ति जो इंजेक्शन / साझा सुइयों और संबंधित सामग्रियों का उपयोग करके दवाओं का उपयोग करता है जो उन्हें एचआईवी और अन्य संक्रमणों का अनुबंध करेगा।'
                                ],
                            ]
                        ]
                    ]
                ),
                Questionnaire::created_at => $currentDateTime
            ]
        ];
        Questionnaire::insert($data);
    }
}
