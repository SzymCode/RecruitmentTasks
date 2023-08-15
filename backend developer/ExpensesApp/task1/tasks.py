'''
0. To run file type `python tasks.py in_1000000.json`.
   Example structure of `in_xxxxx.json`:
   ```
   {
    "items": [
        {
            "package": "FLEXIBLE",
            "created": "2020-03-10T00:00:00",
            "summary": [
                {
                    "period": "2019-12",
                    "documents": {
                        "incomes": 63,
                        "expenses": 13
                    }
                },
                {
                    "period": "2020-02",
                    "documents": {
                        "incomes": 45,
                        "expenses": 81
                    }
                }
            ]
        },
        {
            "package": "ENTERPRISE",
            "created": "2020-03-19T00:00:00",
            "summary": [
                {
                    "period": "2020-01",
                    "documents": {
                        "incomes": 15,
                        "expenses": 52
                    }
                },
                {
                    "period": "2020-02",
                    "documents": {
                        "incomes": 76,
                        "expenses": 47
                    }
                }
            ]
        }
    ]
   }
   ```
1. Please make below tasks described in docstring of functions in 7 days.
2. Changes out of functions body are not allowed.
3. Additional imports are not allowed.
4. Send us your solution (only tasks.py) through link in email.
   In annotations write how much time you spent for each function.
5. The data in the file is normalized.
6. Skip additional functionalities not described directly (like sorting).
7. First we will run automatic tests checking (using: 1 mln and 100 mln items):
   a) proper results and edge cases
   b) CPU usage
   c) memory usage
8. If your solution will NOT pass automatic tests (we allow some errors)
   application will be automatically rejected without additional feedback.
   You can apply again after 90 days.
9. Our develepers will review code (structure, clarity, logic).
'''
import datetime
import collections
import itertools


def task_1(data_in):
    '''
        Return number of items per created[year-month].
        Add missing [year-month] with 0 if no items in data.
        ex. {
            '2020-03': 29,
            '2020-04': 0, # created[year-month] does not occur in data
            '2020-05': 24
        }
    '''

    items_count = collections.defaultdict(int)

    for item in data_in['items']:
        created = datetime.datetime.strptime(item['created'], '%Y-%m-%dT%H:%M:%S').strftime('%Y-%m')
        items_count[created] += 1

    min_date = min(items_count.keys(), default=None)
    max_date = max(items_count.keys(), default=None)

    if min_date and max_date:
        start_date = datetime.datetime.strptime(min_date, '%Y-%m')
        end_date = datetime.datetime.strptime(max_date, '%Y-%m')
        all_dates = [f'{year}-{month:02}' for year, month in
                     itertools.product(range(start_date.year, end_date.year + 1), range(1, 13))]
        missing_dates = set(all_dates) - set(items_count.keys())

        for date in missing_dates:
            items_count[date] = 0

    return items_count

def task_2(data_in):
    '''
        Return number of documents per period (incomes, expenses, total).
        Return only periods provided in data.
        ex. {
            '2020-04': {
                'incomes': 2480,
                'expenses': 2695,
                'total': 5175
            },
            '2020-05': {
                'incomes': 2673,
                'expenses': 2280,
                'total': 4953
            }
        }
    '''

    periods_data = {}
    for item in data_in['items']:
        for summary in item['summary']:
            period = summary['period']
            documents = summary['documents']
            if period not in periods_data:
                periods_data[period] = {'incomes': 0, 'expenses': 0, 'total': 0}
            periods_data[period]['incomes'] += documents['incomes']
            periods_data[period]['expenses'] += documents['expenses']
            periods_data[period]['total'] += documents['incomes'] + documents['expenses']

    return periods_data

def task_3(data_in):
    '''
        Return arithmetic average (integer) number of documents per day
        in the last three months counted from the last period in data (all packages)
        for packages in ['ENTERPRISE', 'FLEXIBLE']
        as one int
        ex. 64
    '''

    last_period = max(summary['period'] for item in data_in['items'] for summary in item['summary'])
    last_period_date = datetime.datetime.strptime(last_period, '%Y-%m')
    three_months_ago = last_period_date - datetime.timedelta(days=90)
    total_docs = 0
    days_count = 0

    for item in data_in['items']:
        if item['package'] in ['ENTERPRISE', 'FLEXIBLE']:
            for summary in item['summary']:
                period = datetime.datetime.strptime(summary['period'], '%Y-%m')
                if three_months_ago <= period <= last_period_date:
                    total_docs += summary['documents']['incomes'] + summary['documents']['expenses']
                    days_count += (period - datetime.datetime(period.year, period.month, 1)).days + 1

    average_docs_per_day = total_docs // days_count if days_count > 0 else 0
    return average_docs_per_day



if __name__ == '__main__':
    import json
    import sys
    try:
        with open(sys.argv[1]) as fp:
            data_in = json.load(fp)
    except IndexError:
        print(f'''USAGE:
    {sys.executable} {sys.argv[0]} <filename>

Example:
    {sys.executable} {sys.argv[0]} in_1000000.json
''')
    else:
        for func in [task_1, task_2, task_3]:
            print(f'\n>>> {func.__name__.upper()}')
            print(json.dumps(func(data_in), ensure_ascii=False, indent=2))

