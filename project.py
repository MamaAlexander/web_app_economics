
from termcolor import colored
import sys
class country:
    def __init__(self, name):
        self.name = name
        self.credits = 20
        self.gov_budget = 100000000000
        self.gpd = 1000
        self.actions = [("Finance market...", [('Stocks...', [('Limit income'),
                                                              ('Restrict/Allow')]),
                                               ('Bonds...', [('Limit income'),
                                                            ('Restrict/Allow')]),
                                               ('Share...', [('Limit the handing of external shares')]),
                                               ('Banks...',  [('Change the key rate')]),
                                               ('Change the size of leverage', ''),
                                               ('Change tax size', ''),
                                               ('Insider trading', '')]),
                        ('Households...', [('Approve transfers', ''),
                                           ('Change tax size', '')]),
                        ('Firms...', [('Approve transfers...', [('To support little and medium buisnesses', ''),
                                                                ('For innovations', '')]),
                                      ('Change tax size', ''),
                                      ('Change tax size for external firms', '')]),
                        ('Market of goods and services...', [('limit the prices to...', [('Grain flour', ''),
                                                                                         ('Fruit and vegetable', ''),
                                                                                         ('Flavoring', ''),
                                                                                         ('Confectionery', ''),
                                                                                         ('Dairy', ''),
                                                                                         ('Egg', ''),
                                                                                         ('Meat', ''),
                                                                                         ('Fish', '')]),
                                                             ('Change the excise tax rate', '')]),
                        ('Another world...', [('Make duties', ''),
                                           ('Embargo', '')])]
        print('Your country is', self.name, 'with', self.gpd, 'number of GPD and', self.gov_budget, 'number of government budget!')

    def game_over(self, x):
        if x == 'exit':
            print(colored('GAME OVER', 'red'))
            sys.exit()
        else:
            return 0

    def show_actions(self):
        index1 = 0
        print('What sphere would you choose to change:')
        for i in range(len(self.actions)):
            print(colored(self.actions[i][0], 'green'))
        x = input()
        self.game_over(x)
        for i in range(len(self.actions)):
            if x == self.actions[i][0]:
                index1 = i
                for j in range(len(self.actions[i][1])):
                    print(colored(self.actions[i][1][j][0], 'green'))
                x = input()
                self.game_over(x)
                for j in range(len(self.actions[index1][1])):
                    if x == self.actions[index1][1][j][0]:
                        for k in range(len(self.actions[index1][1][j][1])):
                            print(colored(self.actions[index1][1][j][1][k], 'green'))




a = input('Name your country:')
if a == 'exit':
    print(colored('GAME OVER', 'red'))
    sys.exit()
b = country(a)
while True:
    print('What would you like to change in your country?')
    x = input('Write "actions" to see what you can change:')
    over = b.game_over(x)
    if x == 'actions':
        b.show_actions()
    else:
        print(colored('Try again', 'red'))
        continue