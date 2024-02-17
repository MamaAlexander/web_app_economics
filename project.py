class country:
    def __init__(self, name):
        self.name = name
        self.credits = 20
        self.gov_budget = 100000000000
        self.gpd = 1000
        self.actions = [("Finance market", [('Stocks', [('Limit income', ),
                                                       ('Restrict/Allow', )]),
                                           ('Bonds', [('Limit income', ),
                                                      ('Restrict/Allow', )]),
                                           ('Share', 'Limit the handing of external shares'),
                                           ('Banks', 'Change the key rate'),
                                           ('Change the size of leverage'),
                                           ('Change tax size'),
                                           ('Insider trading')]),
                        ('Households', [('Approve transfers'),
                                        ('Change tax size')]),
                        ('Firms', [('Approve transfers', [('To support little and medium buisnesses'),
                                                          ('For innovations')]),
                                   ('Change tax size'),
                                   ('Change tax size for external firms')]),
                        ('Market of goods and services', [('limit the prices to', [('Grain flour'),
                                                                                   ('Fruit and vegetable'),
                                                                                   ('Flavoring'),
                                                                                   ('Confectionery'),
                                                                                   ('Dairy'),
                                                                                   ('Egg'),
                                                                                   ('Meat'),
                                                                                   ('Fish')]),
                                                          ('Change the excise tax rate')]),
                        ('Another world', [('Make duties'),
                                           ('Embargo')])]

        print('Your country is', self.name, 'with', self.gpd, 'number of GPD and', self.gov_budget, 'number of government budget!')

    def show_actions(self):
        

a = input('Name your country:')
b = country(a)
while True:
    print('What would you like to change in your country?')
    x = input('Write actions to see what you can change:')
    if x == 'actions':
        b.show_actions()
    else:
        print('Try again')
        continue
