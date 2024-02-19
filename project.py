from termcolor import colored
import sys

def sexit(a):
    if a == 'exit':
        print(colored('GAME OVER', 'red'))
        sys.exit()

class country:

    def __init__(self, name):
        self.name = name
        self.credits = 20
        self.gov_budget = 100000000000
        self.gpd = 1000
        self.actions = [("Finance market...", [('Stocks...', [('Limit income...', [('Limit income of stock exchange', ''),
                                                                                   ('Limit income of investors', ''),
                                                                                   ('Limit income of companies', '')]),
                                                              ('Restrict/Allow...'), [('Maker fees'),
                                                                                      ('Taker fees')]]),
                                               ('Bonds...', [('Limit income', [('Limit income of stock exchange', ''),
                                                                               ('Limit income of investors', ''),
                                                                               ('Limit income of companies', '')]),
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




    def show_actions(self):
        index1 = 0
        print('What sphere would you choose to change:')
        for i in range(len(self.actions)):
            print(colored(self.actions[i][0], 'green'))
        x = input()
        sexit(x)
        for i in range(len(self.actions)):
            if x == self.actions[i][0]:
                index1 = i
                for j in range(len(self.actions[i][1])):
                    print(colored(self.actions[i][1][j][0], 'green'))
        x = input()
        sexit(x)
        for j in range(len(self.actions[index1][1])):
            if x == self.actions[index1][1][j][0]:
                for k in range(len(self.actions[index1][1][j][1])):
                    print(colored(self.actions[index1][1][j][1][k], 'green'))


    def show_actions_improved(self, newlist, topic):
        index1 = 0
        print(colored('What sphere would you choose to change:', 'blue'))
        for i in range(len(newlist)):
            if topic == newlist[i][0]:
                index1 = i
        for i in range(len(newlist)):
            print(colored(newlist[index1][0], 'green'))
        x = input()
        sexit(x)
        if x[-1] != '.':
            return 1
        else:
            show_actions_improved(newlist[index1][1], x)


    # def change_variable(self, x) -> None:

        








# a = input('Name your country:')
# sexit(a)
# b = country(a)
# while True:
#     print('What would you like to change in your country?')
#     x = input('Write "actions" to see what you can change:')

#     sexit(a)

#     if x == 'actions':
#         b.show_actions()

#     else:
#         print(colored('Try again', 'red'))
#         continue



a = input('Name your country:')
sexit(a)
b = country(a)
while True:
    print('What would you like to change in your country?')
    x = input('Write "actions" to see what you can change:')

    sexit(a)

    if x == 'actions':
        print(colored('What sphere would you choose to change:', 'blue'))
        top = input()
        b.show_actions_improved(b.actions, top)

    else:
        print(colored('Try again', 'red'))
        continue