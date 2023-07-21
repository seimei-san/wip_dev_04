import re
from janome.tokenizer import Tokenizer
from janome.analyzer import Analyzer
from janome.charfilter import *
from janome.tokenfilter import *
import MeCab

############# NLP for detecting a request message
def msg_req_detector(msg_decoded):
    judge = False
    judge = msg_reg_detector_mecab(msg_decoded)
    return judge



#########################################
## Detect a request message by Tokenizers
#########################################

def msg_reg_detector_mecab(msg_decoded):
    result = False
    print('#################### MECAB TOKENIZER ########################')

    msg_clean = re.sub("[　「」\n@]", "", msg_decoded)
    separator = "。"
    msg_list = []
    msg_list = re.split('[。?？!！]', msg_clean)
    msg_list.pop()
    if (len(msg_list) == 0):
        msg_list = [msg_clean+separator]
    else: 
        msg_list = [x+separator for x in msg_list]
    
    tagger = MeCab.Tagger()
    for sentense in msg_list:
        print(sentense)
        tag = tagger.parse(sentense)

        if ('命令' in tag):
            print('##### 命令 ######')
            print(tag)
            result = True
            break
        if ('助動詞-マス' in tag and '終助詞' in tag):
            print("##### 助動詞-マス in tag and 終助詞 in tag #####")
            print(tag)
            result = True
            break           
        if ('ネガイ' in tag and '助動詞-マス' in tag):
            print("###### 'ネガイ' in tag and '助動詞-マス' in tag #####")    
            print(tag)    
            result = True
            break
        if ('イライ' in tag and '助動詞-マス' in tag):
            print("####### 'イライ' in tag and '助動詞-マス' in tag) #######")    
            print(tag)    
            result = True
            break
        if ('ヤル' in tag and '終助詞' in tag):
            print("###### 'ヤル' in tag and '終助詞' in tag #####")    
            print(tag)    
            result = True
            break
        if ('スル' in tag and '接続助詞' in tag and '終助詞' in tag):
            print("##### 'スル' in tag and '接続助詞' in tag and '終助詞' in tag ######")    
            print(tag)    
            result = True
            break

    return result


def msg_req_detector_janome_analyzer(msg_decoded):
    print('#################### JANOME ANALYZER ########################')
    msg_clean = re.sub("[　「」\n@]", "", msg_decoded)
    separator = "。"
    msg_list = re.split('[。?？!！]', msg_clean)
    msg_list.pop()
    msg_list = [x+separator for x in msg_list]

    tokenizer = Tokenizer()
    char_filters = [UnicodeNormalizeCharFilter()]
    token_filters = [CompoundNounFilter(), POSKeepFilter(['助詞', '助動詞']), LowerCaseFilter()]
    # token_filters = [CompoundNounFilter(), POSStopFilter(['命令', '助動詞-マス', '終助詞']), LowerCaseFilter()]
    a = Analyzer(char_filters=char_filters, tokenizer=tokenizer, token_filters=token_filters)

    for sentense in msg_list:
        print(sentense)
        for token in a.analyze(sentense):
            print(token)
            print(token.infl_form)
        # print(sentense)

    return


        
            
def msg_req_detector_janome(msg_decoded):
    detect = False
    print('#################### JANOME TOKENIZER ########################')

    msg_clean = re.sub("[　「」\n@]", "", msg_decoded)
    separator = "。"
    msg_list = re.split('[。?？!！]', msg_clean)
    msg_list.pop()
    msg_list = [x+separator for x in msg_list]

    t = Tokenizer()

    for sentense in msg_list:
        print(sentense)
        print(list(t.tokenize(sentense, wakati=True)))
        for token in t.tokenize(sentense):
            print(token)
    return


if __name__ == "__main__":
    
    ########################
    # this is for experiment of Tokenizers 
    ########################
    # msg = "@Symbot1 Kurosawa 以下の資料を月曜日の昼までに準備できますか？　新商品の説明書新商品の販売計画新商品の価格表水曜日に社長がお客様に新商品の説明をするので、正しい資料を準備してください。あと、表紙には以下の写真を使ってください。"
    msg = "@Symbot1 Kurosawa 以下の資料を月曜日の昼までにお願いします。 以下の資料の作成して。新商品の説明書。新商品の販売計画。新商品の価格表。水曜日に社長がお客様に新商品の説明をします。資料は三部用意してください。よろしくお願いします。"
    msg_line = "@Symbot1 Kurosawa 以下の資料を月曜日の昼間でに準備しておいてください。"
    # msg_req_detector_janome_analyzer(msg)
    # msg_req_detector_janome(msg)
    # msg_reg_detector_mecab(msg)
