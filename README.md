# Web-app for economics

[sanyaoui.beget.tech](http://sanyaoui.beget.tech/login/index.php)

## Project Overview

Данный сайт представляет собой экономическую игру, в которой состязуаются 2 государства. Конечный итог этой игры - увеличить индекс своей страны путем принятия различных стратегических решений, которые позволят увеличить показатели страны. 

## Gameplay

В этой игре пользователь может изменять следующие экономические показатели:

- Процентная ставка
- Норма резервирования
- Трансферты для домохозяйств
- Налоги для домохозяйств
- Трансферты для фирм
- Налоги для фирм
- Облигации с фиксированной ставкой купона
- Облигации с переменной ставкий купона
- Индексируемые облигации
- Амортизируемые облигации


Всего игроки имеют 10 ходов. На каждый ход дается 20 кредитов, которые являются эквивалентом времени в реальной жизни (невозможно принять сразу много решений по политике страны). Разные изменения стоят разное количество кредитов, поэтому необходимо тратить их рационально. 

Все изменения, проведенные в течение хода, можно отменить до того, как вы нажали на кнопку "Ready for the next round".
### Key Metrics

После проведения изменений в политике страны, изменяются следующие показатели:

- ВВП на душу населения
- Статус государственного бюджета
- Процент инфляции
- Процент безработицы

### Victory Conditions

Для того, чтобы выиграть в игре необходимо обойти страну оппонента по показателю индекса страны, который рассчитывается следующим образом:

$ Country \> index = 0.2 \cdot GDP_{per \> capita}+ 0.4 \cdot Budget + 0.3 \cdot Inflation \> rate + 0.3 * Unemployment \> rate$ \
где 
$$Budget = \begin{cases} 
0, \> if \> budget \> status \> is \> deficit\\
1, \> if \> budget \> status \> is \> surplus\\
2, \> if \> budget \> status \> is \> balanced\\
\end{cases}$$
